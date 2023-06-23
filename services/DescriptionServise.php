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
  // Получает краткое описание от Chat GPT;
  public function getSummary($item)
  {
    $open_ai_key = $item->account->openai_api_key; //getenv('OPENAI_API_KEY');
    $open_ai = new OpenAi($open_ai_key);

    $chat = $open_ai->chat([
      'model' => $item->account->openai_chat_model, //'gpt-3.5-turbo',
      'messages' => [
        [
          "role" => "user",
          "content" => $item->account->openai_request . ': ' . $item->details[0]->detail_text,
        ],
      ],
      // 'temperature' => 1.0,
      // 'max_tokens' => 4000,
      // 'frequency_penalty' => 0,
      // 'presence_penalty' => 0,
    ]);

    $d = json_decode($chat);

    if (isset($d->choices[0]->message->content)) {
      return $d->choices[0]->message->content;
    } else {
      return false; //'упс...ошибка...'
    }
  }

  public function getDescription()
  {
    // Загружено подробное описание / Аудио преобразовано в подробное описание;
    $descriptionList = Summary::find()
      ->joinWith('details', 'account')
      ->where(['summary_status' => 2])
      ->all();

    // print($descriptionList[0]->details[0]->detail_text);
    // print($descriptionList[0]->account->y_key_id);

    if ($descriptionList) {
      foreach ($descriptionList as $item) {

        if ($item->details[0]->detail_text) {
          $item->summary = $this->getSummary($item);
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
