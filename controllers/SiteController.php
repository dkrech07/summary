<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SignupForm;
use app\services\SummaryService;
use app\services\DescriptionServise;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\ItemForm;
use app\models\Account;
use app\models\AccountForm;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use app\models\Summary;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

use Orhanerday\OpenAi\OpenAi;

class SiteController extends SecuredController
{
    public $layout = 'summary';

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $summaryService = new SummaryService;
        $itemFormModel = new ItemForm();
        $accountFormModel = new accountForm();

        // $descriptionServise = new DescriptionServise;

        // $descriptionServise = new DescriptionServise;
        // $descriptionServise->getDescription();


        // Вывод элементов на странице
        $query = Summary::find()
            ->orderBy('id DESC')
            ->joinWith('summaryStatus');

        $query = $summaryService->getSummaryItems();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit(15)
            ->all();

        // Редактирование учетных данных для Яндекс Storage
        if ($accountFormModel->load(Yii::$app->request->post())) {
            $accountFormModel->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($accountFormModel);
            }

            if ($accountFormModel->validate()) {
                $summaryService->editAccount($accountFormModel);
                $this->refresh();
            }
        }

        // Создание и редактирование элемента
        if ($itemFormModel->load(Yii::$app->request->post())) {

            $itemFormModel->load(Yii::$app->request->post());

            if (isset($itemFormModel->file)) {
                $itemFormModel->file = UploadedFile::getInstance($itemFormModel, 'file');
            }

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($itemFormModel);
            }

            if ($itemFormModel->validate()) {
                $summaryService->createItem($itemFormModel);
                $this->refresh();
            }
        }

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $data = $request->post();

            if (key($data) == 'refresh') {
                // $summaryService->getDescription();
                return json_encode('test', JSON_UNESCAPED_UNICODE);
            }
        }

        // $descriptionServise = new DescriptionServise;
        // $descriptionServise->getDescription();

        return $this->render(
            'index',
            [
                'user' => $user,
                'models' => $models,
                'pages' => $pages,
                'itemFormModel' => $itemFormModel,
                'accountFormModel' => $accountFormModel,
            ]
        );
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->goHome();
    }

    // public function actionRefresh() {
    //     // Обновление данных в списке элементов
    //     if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
    //         $request = Yii::$app->request;
    //         $data = $request->post();

    //         if (key($data) == 'refresh') {

    //             $summaryService->getDescription();
    //             $this->redirect('/');

    //             return json_encode('test', JSON_UNESCAPED_UNICODE);
    //         }
    //     }
    // }

    public function actionEdit()
    {
        $user = Yii::$app->user->identity;
        $summaryService = new SummaryService;
        $itemFormModel = new ItemForm();
        $accountFormModel = new accountForm();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $data = $request->post();

            if (key($data) == 'item_id_detail') {
                return json_encode($summaryService->getDetailItem($data['item_id_detail']), JSON_UNESCAPED_UNICODE);
            }

            if (key($data) == 'item_id_summary') {
                return json_encode($summaryService->getSummmaryItem($data['item_id_summary']), JSON_UNESCAPED_UNICODE);
            }
        }
    }
}
