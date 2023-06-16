<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string|null $y_key_id
 * @property string|null $y_secret_key
 *
 */
class AccountForm extends Model
{
  public $api_secret_key;
  public $y_key_id;
  public $y_secret_key;
  public $bucket_name;
  public $openai_api_key;
  public $openai_chat_model;
  public $openai_request;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'account';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['y_key_id', 'y_secret_key', 'api_secret_key', 'bucket_name', 'openai_api_key', 'openai_chat_model', 'openai_request'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'api_secret_key' => 'API ключ - Ваш секретный ключ',
      'y_key_id' => 'Статический ключ доступа - Идентификатор ключа',
      'y_secret_key' => 'Статический ключ доступа - Ваш секретный ключ',
      'bucket_name' => 'Название бакета',
      'openai_api_key' => 'Ключ OpenAI',
      'openai_chat_model' => 'Модель чата OpenAI',
      'openai_request' => 'Текст запроса к чату GPT',
    ];
  }
}
