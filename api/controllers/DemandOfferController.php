<?php
namespace api\controllers;

use Yii;
use yii\web\Response;
use api\services\DemandOfferService;

class DemandOfferController extends BaseController
{
    public function actionOffer()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = DemandOfferService::getOfferData();
        return $res;
    }

}


