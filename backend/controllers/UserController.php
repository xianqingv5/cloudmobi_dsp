<?php
namespace backend\controllers;

use Yii;

class UserController extends BaseController
{
    public function actionUserIndex()
    {
        return $this->render('index',[

        ]);
    }

    public function actionCreate()
    {
        return $this->render('create', [

        ]);
    }

    public function actionUpdate()
    {

    }
}