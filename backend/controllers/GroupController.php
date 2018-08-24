<?php
namespace backend\controllers;

use backend\services\GroupService;
use Yii;


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
            return GroupService::getGroupData();
        }

        return $this->render('group-index', []);
    }
}