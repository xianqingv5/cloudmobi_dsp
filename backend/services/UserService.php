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

        // 广告代理商查询其所属的广告主
        $group_id = Yii::$app->user->identity->group_id ? Yii::$app->user->identity->group_id : 0;
        switch ($group_id) {
            case 1:// super admin
                $where['all'] = '1=1';
                break;
            case 2:// admin
                $where['group_id'] = "group_id in(3)";
                $where['status'] = "status = 1";
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
                $where['status'] = "status = 1";
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
            $data['email'] = trim(Yii::$app->request->post('email', ''));
            $data['username'] = Yii::$app->request->post('username', '');
            $data['salt'] = Yii::$app->security->generateRandomString(4);
            $data['password'] = md5(Yii::$app->request->post('password') . $data['salt']);
            $data['group_id'] = Yii::$app->request->post('group_id', '4');
            $data['short_name'] = trim(Yii::$app->request->post('short_name'));
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
            self::$res['info'] = 'fail';
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
            // 修改用户状态
            $res = User::updateData($data,$where);

            // 当用户状态改变时
            $all_offer_res = true;
            if ($data['status'] == 2) { //关闭所有offer
                $all_offer_res = OfferService::updateOfferStatusByUser($where['id'], 2);
            } else if($data['status'] == 1) {// offer 未审核
                $all_offer_res = OfferService::updateOfferStatusByUser($where['id'], 3);
            }

            if ($res && $all_offer_res) {
                self::$res['status'] = 1;
                self::$res['info'] = 'success';
                $transaction->commit();
            } else {
                self::$res['info'] = 'error';
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'error';
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
            'password_length' => 'Password length is at least 8 bits.',
            'email_check' => 'The email address is invalid',
        ];

        // short name 验证
        $sn_res = self::checkShortName();
        if (!$sn_res['status']) {
            return $sn_res['info'];
        }

        // email
        $email = trim(Yii::$app->request->post('email', ''));
        if (empty($email))return $info['email'];

        // email 验证
        $preg =  filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$preg) return $info['email_check'];

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
        if (strlen($pwd) < 8) return $info['password_length'];

        // group
        $group_id = Yii::$app->request->post('group_id', 0);
        if (!$group_id) return $info['Permission error'];

        return $info['success'];
    }

    /**
     * 密码修改
     * @param int $uid
     * @param string $type 1:用户修改密码 2:管理员修改用户密码
     * @return array
     */
    public static function updateUserPwd($uid = 0, $type = '1')
    {
        try {
            // 用户修改密码,管理员修改密码时,不验证密码(后台直接生产随机字符串)
            if ($type == 1) {
                // 原密码验证
                $old_pwd = Yii::$app->request->post('old_pwd', '');
                $check_old_pwd = self::checkOldPwd($old_pwd, 0);
                if (!$check_old_pwd) {
                    self::$res['info'] = "Original password error.";
                    return self::$res;
                }

                // 新密码验证
                $new_pwd = Yii::$app->request->post('new_pwd', '');
                $check_new_pwd = Yii::$app->request->post('check_new_pwd', '');
                if (!self::checkNewPwd($new_pwd, $check_new_pwd)) {
                    return self::$res;
                }

                $where['id'] = Yii::$app->user->identity->id;
            } else {
                $new_pwd = Yii::$app->request->post('new_pwd', '');
                $where['id'] = $uid;
            }

            // 修改密码
            $data = [];
            $data['salt'] = Yii::$app->security->generateRandomString(4);
            $data['password'] = md5($new_pwd . $data['salt']);
            $data['update_date'] = date('Y-m-d H:i:s');
            $res = User::updateData($data, $where);
            if ($res) {
                self::$res['status'] = 1;
                self::$res['info'] = 'success';
            } else {
                self::$res['info'] = 'Failure to modify';
            }

        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = "Failure to modify";
        }

        return self::$res;

    }

    /**
     * 新密码验证
     * @param $new_pwd
     * @param $check_new_pwd
     * @return bool
     */
    public static function checkNewPwd($new_pwd, $check_new_pwd)
    {
        // 判断是否为空
        if (empty($new_pwd)) {
            self::$res['info'] = 'Password must be filled.';
            return false;
        }
        // 判断长度
        if (strlen($new_pwd) < 8) {
            self::$res['info'] = 'Password length is at least 8 bits.';
            return false;
        }

        // 判断两次输入是否一致
        if ($new_pwd != $check_new_pwd) {
            self::$res['info'] = 'The input password is inconsistent.';
            return false;
        }

        // 判断密码格式
        $reg = '/^[0-9a-zA-Z-_]{8,}$/';
        if (!preg_match($reg, $new_pwd)) {
            self::$res['info'] = 'Incorrect password format.';
            return false;
        }

        return true;
    }

    /**
     * 旧密码验证
     * @param $old_pwd
     * @param int $uid
     * @return bool
     */
    public static function checkOldPwd($old_pwd, $uid = 0)
    {
        $id = !empty($uid) ? $uid : Yii::$app->user->identity->id;
        $u_res = User::findIdentity($id);
        return ( $u_res->password === md5($old_pwd . $u_res->salt) ) ? true : false;

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
               $where['id'] = 'id in(2,3)';
                break;
            case 2:
               $where['id'] = 'id in(3)';
                break;
            case 3:
                $where['id'] = "id = 0";
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

    /**
     * 获取用户状态
     * @return array
     */
    public static function getUserStatus()
    {
        $res = User::getData(['id', 'status'], ['group_id not in(1,2)']);
        return $res ? array_column($res, 'status', 'id') : [];
    }

    /**
     * 获取随机字符串
     * @param $num
     * @return array
     */
    public static function getCode($num)
    {
        self::$res['status'] = 1;
        self::$res['data']['code'] = Yii::$app->security->generateRandomString($num);
        return self::$res;
    }

    /**
     * 验证用户简称是否已存在
     * @return array
     */
    public static function checkShortName()
    {
        $short_name = trim(Yii::$app->request->post('short_name'));
        $res = User::getData(['count(*) as num'], ["short_name='" . $short_name . "'"]);
        if ($res[0]['num']) {
            self::$res['info'] = 'The Short Name already exists.';
        } else {
            self::$res['status'] = 1;
        }
        return self::$res;
    }
}