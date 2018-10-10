<?php
namespace backend\controllers;

use common\models\OfferReporting;
use Yii;
use backend\services\OfferReportService;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use backend\libs\ExcelLibrary;

class OfferReportController extends BaseController
{
    /**
     * offer report 列表页
     * @return string
     */
    public function actionOfferReportIndex()
    {
        return $this->render('offer-report-index',[]);
    }

    /**
     * offer report 大折线图和表格数据获取
     * @return array
     */
    public function actionOfferReportData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getOfferReportData();
        return $res;
    }

    /**
     * country top 10 数据
     * @return array
     */
    public function actionCountryTopBar()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getCountryTopBar();
        return $res;
    }

    /**
     * offer top 折线图
     * @return array
     */
    public function actionOfferLine()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getOfferTopLine();
        return $res;
    }

    /**
     * offer search config
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionGetOfferSearch()
    {
        if (!Yii::$app->request->isPost || !Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = OfferReportService::getOfferSearch();
        return $res;
    }

    public function actionDownloadReport()
    {
        // 报表标题
        $header         = array_values( $show_fields );

        $data = [];
        // $data           = webReportService::processExcelData($params, $show_fields, $is_reward_video_type);

        // 文件名
        $filename       = 'Reporting_st_et.xls';

        ExcelLibrary::getExcel($header, $data, $filename);
    }
}