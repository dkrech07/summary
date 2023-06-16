<?php

namespace app\widgets;

use yii\base\Widget;

class ModalForm extends Widget
{
  public $formModel;
  public $formType;

  public function run()
  {
    return $this->render("{$this->formType}", [
      'formModel' => $this->formModel
    ]);
  }
}
