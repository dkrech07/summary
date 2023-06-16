<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * This is the model class for table "summary".
 *
 * @property int $id
 * @property string $title
 * @property string|null $detail
 * @property string|null $summary
 * @property string $updated_at
 *
 * @property User $createdUser
 * @property Status $summaryStatus
 */
class ItemForm extends Model
{
  public $title;
  public $file;
  public $detail;
  public $summary;

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
      [['title'], 'required'],
      [['detail', 'summary'], 'string'],
      [['title'], 'string', 'max' => 256],
      [['file'], 'file', 'extensions' => 'mp3, wav, ogg',],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'title' => 'Название записи',
      'file' => 'File',
      'detail' => 'Подробный текст',
      'summary' => 'Краткий текст',
    ];
  }
}
