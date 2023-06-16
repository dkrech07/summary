<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Подробное описание</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>

      <?php $form = ActiveForm::begin(['id' => 'detail']); ?>
      <div class="modal-body">
        <div class="mb-3">
          <?= $form->field($formModel, 'title')->textInput(['autofocus' => true, 'placeholder' => "Краткая информация о записи диалога"]) ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'summary')->textarea(['rows' => '18', 'placeholder' => "Добавьте сюда текст"]) ?>
        </div>
      </div>
      <div class="modal-footer">
        <div class="tabs"></div>
        <div class="controls">
          <!-- <button type="submit" class="btn btn-primary">Сохранить изменения</button> -->
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
      <?php ActiveForm::end(); ?>

    </div>
  </div>
</div>