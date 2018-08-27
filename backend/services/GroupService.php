<?php
namespace backend\services;

use Yii;
use common\models\UserGroup;
use common\models\GroupRelationPriv;

class GroupService extends BaseService
{
    public static function getGroupPrev()
    {
        $res = ['status' => 0, 'info' => '', 'data' => []];
        $group_id = (int)Yii::$app->request->post('group_id', 0);
        if (!$group_id) {
            $res['info'] = '参数错误';
            return $res;
        }
        $group_prev = Yii::$app->params['GROUP_PREV'];
        if (empty($group_prev)) {
            $res['info'] = '群组配置为空';
            return $res;
        }

        // 组装群组信息
        $i = 0; $group_all = [];
        foreach ($group_prev as $k=>$v){
            $group_all[$i]['label'] = $v;
            $group_all[$i]['key'] = $k;
            $i++;
        }
        $res['status'] = 1;
        $res['data']['all'] = $group_all;

        // 查询群组已有权限
        $group_res = GroupRelationPriv::getData(['prev_url'], ["group_id='" . $group_id . "'"]);
        $res['data']['group'] = [];
        if (!empty($group_res)) {
            $res['data']['group'] = array_column($group_res, 'prev_url');
        }

        return $res;
    }

    public static function addGroupPrev()
    {
        $res = ['status' => 0, 'info' => '', 'data' => []];
        $group_id = (int)Yii::$app->request->post('group_id', 2);
        if (empty($group_id)) {
            $res['info'] = '参数错误';
            return $res;
        }
        $prev = Yii::$app->request->post('prev', ['1']);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $prev_res = true;
            if (!empty($prev)) {
                // 判断表中是否已有权限
                $r = GroupRelationPriv::getData(['count(*) as num'], ["group_id='" . $group_id . "'"]);
                if ($r[0]['num']) {

                }
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            $transaction->rollBack();
            $res['info'] = $e->getMessage();
            return $res;
        }

        echo "<pre>";var_dump(Yii::$app->request->post());die;
    }
}