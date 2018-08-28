<?php
namespace backend\controllers;

use Yii;
use backend\services\UserService;
use yii\web\Response;

class UserController extends BaseController
{
    public function actionUserIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $res = UserService::addUserData();
        }

        return $this->render('index',[

        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

        }

        return $this->render('create', [

        ]);
    }

    public function actionUpdate()
    {

    }

    public function actionCheckEmail()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::checkEmail();
        return $res;
    }

    public function actionGetRole()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::getRole();
        return $res;
    }

}