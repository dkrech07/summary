<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="modal fade" id="itemModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Подробное описание</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin(['id' => 'item-form']); ?>
        <?= $form->field($formModel, 'detail')->textarea(['autofocus' => true, 'rows' => '18'])->label(false) ?>
        <?php ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Открыть второе модальное окно</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel2">Итоговая информация</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin(['id' => 'item-form']); ?>
        <?= $form->field($formModel, 'summary')->textarea(['autofocus' => true, 'rows' => '18'])->label(false) ?>
        <?php ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Вернуться к первому</button>
      </div>
    </div>
  </div>
</div>

<!-- <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Открыть первое модальное окно</a> -->

<?php $form = ActiveForm::begin(['id' => 'audio']); ?>

<div class="modal-body">
  <?= $form->field($formModel, 'summary')->textarea(['autofocus' => true, 'rows' => '18'])->label(false) ?>
</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-primary">Сохранить изменения</button>
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
</div>
<?php ActiveForm::end(); ?>

<?php echo Yii::$app->dropzone::widget([
  'options' => [
    'url' => '/site/index',
    'maxFilesize' => '200',

  ],
  'clientEvents' => [
    'complete' => "function(file){console.log(file)}",
    'removedfile' => "function(file){alert(file.name + ' is removed')}",
  ],
]);
?>