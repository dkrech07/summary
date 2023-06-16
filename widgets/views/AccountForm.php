<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Настройки для Object Storage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <?php $form = ActiveForm::begin(['id' => 'account']); ?>
      <div class="modal-body">
        <h3 class="account-title">Настройки Yandex Cloud</h3>
        <div class="mb-3">
          <?= $form->field($formModel, 'api_secret_key')->textInput(['autofocus' => true]); ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'y_key_id')->textInput(); ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'y_secret_key')->textInput(); ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'bucket_name')->textInput(); ?>
        </div>
        <h3 class="account-title">Настройки OpenAI</h3>
        <div class="mb-3">
          <?= $form->field($formModel, 'openai_api_key')->textInput(); ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'openai_chat_model')->textInput(); ?>
        </div>
        <div class="mb-3">
          <?= $form->field($formModel, 'openai_request')->textInput(); ?>
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