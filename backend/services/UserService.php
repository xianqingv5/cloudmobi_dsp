<?php
namespace backend\services;

use Yii;
use common\models\User;
use common\models\UserGroup;
use common\models\UserRelationUser;

class UserService extends BaseService
{
    // 初始化结果返回数据
    public static $res = ['status' => 0, 'info' => '', 'data' => []];

    public static function getUserData()
    {
        $where['status'] = "status = 1";
        // 广告代理商查询其所属的广告主
        $group_id = Yii::$app->user->identity->group_id ? Yii::$app->user->identity->group_id : 0;
        switch ($group_id) {
            case 1:// super admin
                break;
            case 2:// admin
                $where['group_id'] = "group_id in(3)";
                break;
            case 3:// 广告代理商
                $uid = Yii::$app->user->identity->id;
                $user_res = UserRelationUser::getData(['relation_user_id'], ["user_id='".$uid."'"]);
                if ($user_res) {
                    $uids = array_column($user_res, 'relation_user_id');
                    $where['user_id'] = "id in(" . implode(',', $uids) . ")";
                } else {
                    $where['user_id'] = "id = 0";
                }
                break;
            default :
                $where['user_id'] = "id = 0";
                break;
        }

        $res = User::getData(['*'], $where);
        return $res;

    }

    /**
     * 创建用户
     * @return array
     */
    public static function addUserData()
    {
        if ($info = self::checkParams()) {
            self::$res['info'] = $info;
            return self::$res;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // 创建用户
            $data = [];
            $date = date('Y-m-d H:i:s');
            $data['email'] = Yii::$app->request->post('email', '');
            $data['username'] = Yii::$app->request->post('username', '');
            $data['salt'] = Yii::$app->security->generateRandomString(4);
            $data['password'] = md5(Yii::$app->request->post('password') . $data['salt']);
            $data['group_id'] = Yii::$app->request->post('group_id', '4');
            $data['comment'] = Yii::$app->request->post('comment', '');
            $data['status'] = 1;
            $data['create_date'] = $date;
            $data['update_date'] = $date;
            $u_res = User::addData($data);

            // 代理广告主创建用户,关联id
            $uu_res = true;
            if (isset(Yii::$app->user->identity->group_id) && Yii::$app->user->identity->group_id == Yii::$app->params['AGENT_ADVERTISERS']) {
                $data2 = [];
                $data2['relation_user_id'] = Yii::$app->db->getLastInsertID();
                $data2['user_id'] = Yii::$app->user->identity->id;
                $data2['type'] = 1;
                $data2['create_date'] = $date;
                $data2['update_date'] = $date;
                $uu_res = UserRelationUser::addData($data2);

            }

            if ($u_res && $uu_res) {
                self::$res['status'] = 1;
                $transaction->commit();
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = $e->getMessage();
            $transaction->rollBack();
        }

        return self::$res;
    }

    /**
     * 修改用户数据
     * @return array
     */
    public static function updateUserData()
    {
        $data['username'] = Yii::$app->request->post('username', '');
        $data['comment'] = Yii::$app->request->post('comment', '');
        $where['id'] = Yii::$app->request->post('id', 0);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $res = User::updateData($data,$where);
            if ($res) {
                self::$res['status'] = 1;
                self::$res['info'] = 'success';
                $transaction->commit();
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = $e->getMessage();
            $transaction->rollBack();
        }

        return self::$res;
    }

    /**
     * 修改用户状态
     * @return array
     */
    public static function updateUserStatus()
    {
        $where['id'] = Yii::$app->request->post('id', 0);
        $data['status'] = Yii::$app->request->post('status', 1);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $res = User::updateData($data,$where);
            if ($res) {
                self::$res['status'] = 1;
                self::$res['info'] = 'success';
                $transaction->commit();
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = $e->getMessage();
            $transaction->rollBack();
        }

        return self::$res;
    }

    /**
     * 参数验证
     * @return mixed
     */
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

        // 验证邮箱是否存在
        $e_res = self::checkEmail();
        if (!$e_res['status']) {
            return $e_res['info'];
        }

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

    /**
     * 验证email是否已存在
     * @return array
     */
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

    /**
     * 获取当前用户可创建的组
     * @return array
     */
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