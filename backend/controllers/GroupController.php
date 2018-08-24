<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\services\GroupService;


class GroupController extends BaseController
{
    /**
     * 群组列表页
     * @return array|string
     */
    public function actionGroupIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;// 设置响应数据类型
            $data = GroupService::getGroupData();
            return $data;
        }

        return $this->render('group-index', []);
    }
}