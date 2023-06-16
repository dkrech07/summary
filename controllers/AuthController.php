<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;

// use yii\web\Response;
// use yii\filters\VerbFilter;
// use app\models\ContactForm;
// use app\models\User;
// use app\models\SignupForm;

class AuthController extends Controller
{

  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'only' => ['index'],
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['?']
          ]
        ]
      ]
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {

      if ($model->validate()) {
        $user = $model->getUser();
        Yii::$app->user->login($user);
        $this->redirect('/site');
      }
    }

    $model->password = '';
    return $this->render('index', [
      'model' => $model,
    ]);
  }

  public function beforeAction($action)
  {
    if (!Yii::$app->user->isGuest) {
      // $this->redirect('/site/index');
      $this->redirect('/summary/web/site/index');
      return false;
    }
    return true;
  }
}
