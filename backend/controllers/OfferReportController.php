<?php
namespace backend\controllers;

use common\models\OfferReporting;
use Yii;
use backend\services\OfferReportService;
use yii\web\Response;

class OfferReportController extends BaseController
{
    public function actionOfferReportIndex()
    {
        return $this->render('offer-report-index',[]);
    }

    public function actionOfferReportData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getOfferReportData();
        return $res;
    }

    public function actionCountryTopBar()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getCountryTopBar();
        return $res;
    }

    public function actionOfferLine()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getOfferTopLine();
        return $res;
    }

    public function actionGetOfferId()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getOfferId();
        return $res;
    }
}