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
use app\services\SummaryService;

use Aws\Exception\AwsException;
use yii\web\UploadedFile;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;


class DescriptionServise
{

  public function getDescription()
  {
    // '1' => 'Конвертация речи в текст'
    // '2' => 'Получение краткого описания'
    // '3' => 'Готово'
    // '4' => 'Ошибка, проверьте исходные данные'

    $summaryService = new SummaryService;

    // print_r($summaryService);

    $account = $summaryService->accessCheck();

    // print_r($account);

    if (!$account) {
      return;
    }

    // Загружено аудио;
    $audioList = Summary::find()
      ->where(['created_user' => Yii::$app->user->identity->id, 'summary_status' => 1])
      ->all();

    // Загружено подробное описание / Аудио преобразовано в подробное описание;
    $descriptionList = Summary::find()
      ->joinWith('details')
      ->where(['created_user' => Yii::$app->user->identity->id, 'summary_status' => 2])
      ->all();

    // Подготовлено краткое описание;
    // $summaryList = Summary::find()
    //   ->where(['created_user' => Yii::$app->user->identity->id, 'summary_status' => 3])
    //   ->all();

    if ($audioList) {
      foreach ($audioList as $item) {
        if (isset($item->decode_id)) {
          $url = "https://operation.api.cloud.yandex.net/operations/";

          $client = new Client([
            'base_uri' => $url,
          ]);

          $response = $client->request('GET', $item->decode_id, [
            'headers' => [
              'Authorization' => 'Api-Key ' . $account->api_secret_key
            ]
          ]);

          $body = $response->getBody();
          $arr_body = json_decode($body);

          if ($arr_body->done) {
            $chunksList = $arr_body->response->chunks;
            $item->updated_at = $summaryService->getCurrentDate();
            $item->summary_status = 2;

            $newDetail = new Detail;
            $newDetail->summary_id = $item->id;
            $newDetail->detail_text = $arr_body->response->chunks[0]->alternatives[0]->text; // $chunkItem->alternatives[0]->text;

            $transaction = Yii::$app->db->beginTransaction();
            try {
              $item->save();
              $newDetail->save();

              $transaction->commit();
            } catch (\Exception $e) {
              $transaction->rollBack();
              throw $e;
            } catch (\Throwable $e) {
              $transaction->rollBack();
            }
          }
        }
      }
    }

    if ($descriptionList) {
      foreach ($descriptionList as $item) {

        $descriptionText = $summaryService->getSummary($item->details[0]->detail_text, $account);
        // print_r($item->details[0]->detail_text);
        // exit;

        if ($item->details[0]->detail_text) {
          $item->summary = $summaryService->getSummary($descriptionText, $account);
          $item->summary_status = 3;

          $transaction = Yii::$app->db->beginTransaction();
          try {
            $item->save();
            $transaction->commit();
          } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
          } catch (\Throwable $e) {
            $transaction->rollBack();
          }
        }
      }
      // $this->refresh();
    }
  }
}
