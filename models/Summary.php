<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "summary".
 *
 * @property int $id
 * @property int $number
 * @property int $summary_status
 * @property string $title
 * @property string|null $file
 * @property string|null $decode_id
 * @property string|null $summary
 * @property int $created_user
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $createdUser
 * @property Detail[] $details
 * @property Status $summaryStatus
 */
class Summary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'summary_status', 'title', 'created_user', 'created_at', 'updated_at'], 'required'],
            [['number', 'summary_status', 'created_user'], 'integer'],
            [['file', 'decode_id', 'summary'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['created_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_user' => 'id']],
            [['summary_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['summary_status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'summary_status' => 'Summary Status',
            'title' => 'Title',
            'file' => 'File',
            'decode_id' => 'Decode ID',
            'summary' => 'Summary',
            'created_user' => 'Created User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CreatedUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_user']);
    }

    /**
     * Gets query for [[Details]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(Detail::class, ['summary_id' => 'id']);
    }

    /**
     * Gets query for [[SummaryStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSummaryStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'summary_status']);
    }
}
