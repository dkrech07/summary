<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail".
 *
 * @property int $id
 * @property int $summary_id
 * @property string|null $detail_text
 *
 * @property Summary $summary
 */
class Detail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['summary_id'], 'required'],
            [['summary_id'], 'integer'],
            [['detail_text'], 'string'],
            [['summary_id'], 'exist', 'skipOnError' => true, 'targetClass' => Summary::class, 'targetAttribute' => ['summary_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'summary_id' => 'Summary ID',
            'detail_text' => 'Detail Text',
        ];
    }

    /**
     * Gets query for [[Summary]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSummary()
    {
        return $this->hasOne(Summary::class, ['id' => 'summary_id']);
    }
}
