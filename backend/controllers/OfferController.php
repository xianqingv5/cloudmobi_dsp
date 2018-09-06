<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\services\OfferService;
use backend\libs\SpiderLibrary;
use yii\web\ForbiddenHttpException;

class OfferController extends BaseController
{
    public function actionOfferIndex()
    {
        return $this->render('offer-index');
    }

    public function actionOfferCreate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            echo "<pre>";var_dump(Yii::$app->request->post());die;
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = OfferService::addOfferData();
            return $res;
        }

        return $this->render('offer', ['type' => 'create']);
    }

    public function actionOfferUpdate()
    {
        return $this->render('offer', ['type' => 'update']);
    }

    public function actionOfferUpdateStatus()
    {

    }

    public function actionDelOfferImg()
    {

    }

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