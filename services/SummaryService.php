<?php

namespace app\services;

use Yii;
use app\models\AccountForm;
use app\models\Summary;
use app\models\ItemForm;
use app\models\Account;
use app\models\Detail;
use app\models\DetailForm;
use app\models\SummaryForm;
use yii\db\Expression;
use Aws\S3\S3Client;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use GuzzleHttp\Client;
use Orhanerday\OpenAi\OpenAi;

use Aws\Exception\AwsException;
use yii\web\UploadedFile;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

class SummaryService
{
  // Выводит список записей;
  public function getSummaryItems()
  {
    return Summary::find()
      ->orderBy('id DESC')
      ->joinWith('summaryStatus');
  }

  // Выводит подробное описание;
  public function getDetailItem($data)
  {
    $detailItems = Detail::find()
      ->where(['summary_id' => $data])
      ->all();

    $summaryItem = Summary::find()
      ->where(['id' => $data])
      ->one();

    $detailItemsList = [];

    foreach ($detailItems as $detailItem) {
      $detailForm = new DetailForm;
      $detailForm->summary_id = $detailItem->summary_id;
      $detailForm->title = $summaryItem->title;
      $detailForm->detail_text = $detailItem->detail_text;
      $detailItemsList[] = $detailForm;
    }

    return $detailItemsList;
  }

  // Выводит краткое описание;
  public function getSummmaryItem($data)
  {
    $summaryItem =  Summary::find()
      ->where(['id' => $data])
      ->one();

    $summaryForm = new SummaryForm;
    $summaryForm->summary_id = $summaryItem->id;
    $summaryForm->title = $summaryItem->title;
    $summaryForm->summary_text = $summaryItem->summary;

    return $summaryForm;
  }

  // Проверка наличия доступов
  public static function accessCheck()
  {
    $account = Account::find()
      ->where(['user_id' => Yii::$app->user->identity->id])
      ->one();

    if (
      !isset($account->y_key_id) || !isset($account->y_secret_key) || !isset($account->api_secret_key)
      || !isset($account->bucket_name) || !isset($account->openai_api_key) || !isset($account->openai_chat_model)
      || !isset($account->openai_request)
    ) {
      return false;
    } else {
      return $account;
    }
  }

  // Получает текущую дату и время;
  public static function getCurrentDate(): string
  {
    $expression = new Expression('NOW()');
    $now = (new \yii\db\Query)->select($expression)->scalar();
    return $now;
  }

  // Создает новую запись;
  public function createItem(ItemForm $itemFormModel)
  {

    $account = $this->accessCheck(); // Перед созданием записи в системе, проверяю есть ли у пользователя необходимые данные для доступа к Y.Storage/ChatGPT;
    if (!$account) {
      return;
    }

    $newItem = new Summary;

    $itemsCount = Summary::find()
      ->where(['created_user' => Yii::$app->user->identity->id])
      ->count();

    $newItem->number = $itemsCount + 1;
    $newItem->title = $itemFormModel->title;
    $newItem->created_user = Yii::$app->user->identity->id;
    $newItem->created_at = $this->getCurrentDate();
    $newItem->updated_at = $this->getCurrentDate();

    // Если был загружен аудио-файл;
    if ($itemFormModel->file) {
      $fileName = substr(md5(microtime() . rand(0, 9999)), 0, 8) . '.' . $itemFormModel->file->extension;
      $uploadPath = './upload' . '/' . $fileName;
      $itemFormModel->file->saveAs($uploadPath);

      $newItem->file = $this->uploadYandexStorage($uploadPath, $fileName, $account);
      $newItem->decode_id = $this->decodeAudio($newItem->file, $itemFormModel->file->extension, $account);
      $newItem->summary_status = 1; // Конвертация речи в текст;

      $transaction = Yii::$app->db->beginTransaction();
      try {
        $newItem->save();
        $transaction->commit();
      } catch (\Exception $e) {
        $transaction->rollBack();
        throw $e;
      } catch (\Throwable $e) {
        $transaction->rollBack();
      }
    }
    // Если загружено подробное описание; 
    else {
      $newItem->summary_status = 2;

      $transaction1 = Yii::$app->db->beginTransaction();
      try {
        $newItem->save();
        $transaction1->commit();
      } catch (\Exception $e) {
        $transaction1->rollBack();
        throw $e;
      } catch (\Throwable $e) {
        $transaction1->rollBack();
      }

      $newDetail = new Detail;
      $newDetail->detail_text = $itemFormModel->detail;
      $newDetail->summary_id = $newItem->id;

      $transaction2 = Yii::$app->db->beginTransaction();
      try {
        $newDetail->save();
        $transaction2->commit();
      } catch (\Exception $e) {
        $transaction2->rollBack();
        throw $e;
      } catch (\Throwable $e) {
        $transaction2->rollBack();
      }
    }
  }
}
