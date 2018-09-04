<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\services\OfferService;

class OfferController extends BaseController
{
    public function actionOfferIndex()
    {
        return $this->render('offer-index');
    }

    public function actionOfferCreate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::getUserData();
            return $res;
        }

        return $this->render('offer');
    }

    public function actionOfferUpdate()
    {

    }

    public function actionOfferUpdateStatus()
    {

    }

    public function actionDelOfferImg()
    {

    }

    public function actionGetOfferConfig()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferService::getOfferConfig();
        return $res;
    }
}