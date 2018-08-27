<?php
namespace backend\services;

use Yii;
use common\models\User;

class UserService extends BaseService
{
    // 初始化结果返回数据
    public static $res = ['status' => 0, 'info' => '', 'data' => []];

    public static function getUserData()
    {

    }

    public static function addUserData()
    {
        if ($info = self::checkParams()) {
            self::$res['info'] = $info;
            return self::$res;
        }

        return self::$res;
    }

    public static function updateUserData()
    {

    }

    public static function checkParams()
    {
        $info = [
            'success' => '',
            'email' => 'Email is invalid',
            'empty_password' => 'Password is not empty',
            'password' => 'Password inconsistent',
            'group' => 'Permission error',
        ];

        // email
        $email = trim(Yii::$app->request->post('email', ''));
        if (empty($email))return $info['email'];

        // password
        $pwd = trim(Yii::$app->request->post('password', ''));
        $check_pwd = trim(Yii::$app->request->post('check_password', ''));
        if (empty($pwd)) return $info['empty_password'];
        if ($pwd != $check_pwd) return $info['password'];

        // group
        $group_id = Yii::$app->request->post('group_id', 0);
        if (!$group_id) return $info['Permission error'];

        return $info['success'];
    }
}