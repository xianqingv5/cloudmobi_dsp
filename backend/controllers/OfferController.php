<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\services\OfferService;
use backend\libs\SpiderLibrary;
use yii\web\ForbiddenHttpException;

class OfferController extends BaseController
{
    /**
     * offer list
     * @return array|string
     */
    public function actionOfferIndex()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::getOfferList();
            return $res;
        }

        return $this->render('offer-index');
    }

    /**
     * offer create
     * @return array|string
     */
    public function actionOfferCreate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            //echo "<pre>";var_dump(Yii::$app->request->post());die;
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::addOfferData();
            return $res;
        }

        return $this->render('offer', ['type' => 'create']);
    }

    /**
     * offer update
     * @return array|string
     */
    public function actionOfferUpdateInfo()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::getDemandOfferData();
            return $res;
        }

        return $this->render('offer', ['type' => 'update']);
    }

    public function actionOfferUpdate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::getDemandOfferData();
            return $res;
        }
    }


    /**
     * offer status update
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionOfferUpdateStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::updateOfferStatus();
            return $res;
        }
        throw new ForbiddenHttpException();
    }

    /**
     * 抓取 url 信息
     * @throws ForbiddenHttpException
     */
    public function actionGetUrlInfo()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $res = SpiderLibrary::main();
            echo json_encode($res);die;
        }

        throw new ForbiddenHttpException();
    }


    /**
     * 获取创建offer时各种配置信息
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionGetOfferConfig()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::getOfferConfig();
            return $res;
        }

        throw new ForbiddenHttpException();
    }
}