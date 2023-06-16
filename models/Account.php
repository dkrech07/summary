<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $y_key_id
 * @property string|null $y_secret_key
 * @property string|null $api_secret_key
 * @property string|null $bucket_name
 * @property string|null $openai_api_key
 * @property string|null $openai_chat_model
 * @property string|null $openai_request
 *
 * @property User $user
 */
class Account extends \yii\db\ActiveRecord
{
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
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['y_key_id', 'y_secret_key', 'api_secret_key', 'bucket_name', 'openai_api_key', 'openai_chat_model', 'openai_request'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'y_key_id' => 'Y Key ID',
            'y_secret_key' => 'Y Secret Key',
            'api_secret_key' => 'Api Secret Key',
            'bucket_name' => 'Bucket Name',
            'openai_api_key' => 'Openai Api Key',
            'openai_chat_model' => 'Openai Chat Model',
            'openai_request' => 'Openai Request',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
