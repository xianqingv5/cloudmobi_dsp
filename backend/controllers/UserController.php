<?php
namespace backend\controllers;

use Yii;
use backend\services\UserService;
use yii\web\Response;

class UserController extends BaseController
{
    /**
     * 获取用户列表信息
     * @return array|string
     */
    public function actionUserIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = UserService::getUserData();
            return $res;
        }

        return $this->render('index',[]);
    }

    /**
     * 创建用户
     * @return array|string
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = UserService::addUserData();
            return $res;
        }

        return $this->render('create', []);
    }

    /**
     * 修改用户信息
     * @return array
     */
    public function actionUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::updateUserData();
        return $res;
    }

    /**
     * 修改用户状态
     * @return array
     */
    public function actionUpdateUserStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::updateUserStatus();
        return $res;
    }

    /**
     * 修改自己的密码
     * @return array|string
     */
    public function actionUpdatePwd()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = UserService::updateUserPwd();
            return $res;
        }

        return $this->render('pwd', [
            'uid' => Yii::$app->user->identity->id,
        ]);
    }


    /**
     * 修改用户密码
     * @return array
     */
    public function actionUpdateUserPwd()
    {
        if (!Yii::$app->request->isAjax && !Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $uid = Yii::$app->request->post('id', 0);
            $res = UserService::updateUserPwd($uid);
            return $res;
        }
    }

    public function actionGetCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::getCode(8);
        return $res;
    }

    /**
     * 验证邮箱是否已存在
     * @return array
     */
    public function actionCheckEmail()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::checkEmail();
        return $res;
    }

    /**
     * 获取可创建的组权限
     * @return array
     */
    public function actionGetRole()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = UserService::getRole();
        return $res;
    }

}