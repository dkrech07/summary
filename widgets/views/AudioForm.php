<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use devgroup\dropzone\DropZone;
use kato\DropZone;
use yii\base\Component;

use app\components;

?>

<div class="modal fade" id="audioModal" tabindex="-1" aria-labelledby="audioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Загрузка аудиозаписи диалога</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <?php $form = ActiveForm::begin(['id' => 'item-form', 'options' => ['enctype' => 'multipart/form-data']]) ?>
      <div class="modal-body">
        <div class="mb-3">
          <?= $form->field($formModel, 'title')->textInput(['autofocus' => true, 'placeholder' => "Краткая информация о записи диалога"]) ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'file')->fileInput(['required' => true]) ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>