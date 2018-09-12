<?php
namespace backend\controllers;

use Yii;
use backend\services\OfferReportService;

class OfferReportController extends BaseController
{
    public function actionOfferReportIndex()
    {
        return $this->render('offer-report-index',[]);
    }

    public function actionOfferReportChar()
    {

    }

    public function actionOfferReportTable()
    {

    }
}