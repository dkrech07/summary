<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="modal fade" id="NewItemModal" tabindex="-1" aria-labelledby="NewItemModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Создание новой записи</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <ol class="list-group list-group-numbered">
          <li class="new-audio list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
              <div class="fw-bold">Загрузить аудиозапись</div>
              Аудиозапись будет переведена в текст, а затем преобразована в краткое описание.
            </div>
            <i class="bi bi-mic"></i>
          </li>
          <li class="new-detail list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
              <div class="fw-bold">Добавить подробное описание</div>
              Подробное описание будет преобразовано в краткое.
            </div>
            <i class="bi bi-file-text"></i>
          </li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>