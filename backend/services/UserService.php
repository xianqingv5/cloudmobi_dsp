<?php
namespace backend\services;

use Yii;
use common\models\User;
use common\models\UserGroup;

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

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $data = [];
            $data['email'] = Yii::$app->request->post('email', '');
            
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = $e->getMessage();
            $transaction->rollBack();
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

    public static function checkEmail()
    {
        $email = Yii::$app->request->post('email');
        $res = User::getData(['count(*) as num'], ["email='" . $email . "'"]);
        if ($res[0]['num']) {
            self::$res['info'] = 'The mailbox already exists.';
        } else {
            self::$res['status'] = 1;
        }
        return self::$res;
    }

    public static function getRole()
    {
        $group_id = isset(Yii::$app->user->identity->group_id) ? Yii::$app->user->identity->group_id : 1;
        $where = ['1=1'];
        switch ($group_id) {
            case 1:// 群组id
               $where['id'] = 'id !=1';
                break;
            case 2:
               $where['id'] = 'id not in(1,2)';
                break;
            case 3:
                $where['id'] = "id = 4";
                break;
            default :
                $where['id'] = 'id = 0';
                break;
        }
        $g_res = UserGroup::getData(['id', 'group_name'], $where);
        self::$res['status'] = 1;
        self::$res['data'] = $g_res;
        return self::$res;
    }
}