<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\SummaryAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

SummaryAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
  <?php $this->beginBody() ?>

  <header id="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand">Summary</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Переключатель навигации">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
          <?php if (Yii::$app->user->isGuest) : ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/auth/index">Авторизация</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/signup/index">Регистрация</a>
              </li>
            </ul>
          <?php else : ?>
            <!-- <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
              <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form> -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="add-new-item nav-link active" aria-current="page" href="#">Добавить запись</a>
              </li>
              <li class="nav-item">
                <a class="settings-item nav-link active" aria-current="page" href="#">Настройки</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/site/logout">Выход</a>
              </li>
              <li class="nav-item refresh">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-arrow-clockwise"></i></button>
              </li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </nav>
    <?php
    ?>
  </header>

  <main id="main" class="summary-main flex-shrink-0" role="main">
    <div class="container summary-container">
      <?php if (!empty($this->params['breadcrumbs'])) : ?>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
      <?php endif ?>
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
  </main>

  <footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
      <div class="row text-muted">
        <div class="col-md-6 text-center text-md-start">&copy; Summary <?= date('Y') ?></div>
        <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
      </div>
    </div>
  </footer>

  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>