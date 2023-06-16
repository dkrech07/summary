<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "detail".
 *
 * @property int $id
 * @property int $summary_id
 * @property string $title
 * @property string|null $summary_text
 *
 * @property Summary $summary
 */
class SummaryForm extends Model
{

  public $summary_id;
  public $title;
  public $summary_text;

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
      [['summary_id'], 'required'],
      [['summary_id'], 'integer'],
      [['title', 'summary_text'], 'string'],
      [['summary_id'], 'exist', 'skipOnError' => true, 'targetClass' => Summary::class, 'targetAttribute' => ['summary_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      // 'id' => 'ID',
      'summary_id' => 'Summary ID',
      'summary_text' => 'Detail Text',
      'title' => 'Title',
    ];
  }

  // /**
  //  * Gets query for [[Summary]].
  //  *
  //  * @return \yii\db\ActiveQuery
  //  */
  // public function getSummary()
  // {
  //   return $this->hasOne(Summary::class, ['id' => 'summary_id']);
  // }
}
