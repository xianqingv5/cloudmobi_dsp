<?php
namespace backend\services;

use Yii;
use common\models\User;
use common\models\ThirdPartyMonitoring;
use common\models\Advertiser;
use common\models\DemandOffers;

class OfferService extends BaseService
{
    public static $res = ['status'=>0, 'info'=>'', 'data'=>[]];

    public static function addOfferData()
    {
        // 验证参数
        $model = new DemandOffers();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

        } else {
            self::$res['info'] = $model->errors;
        }

        return self::$res;
    }

    /**
     * 获取offer各种配置信息
     * @return array
     */
    public static function getOfferConfig()
    {
        // 获取offer所属者
        $user_res = User::getData(['id', 'email'], ['group_id = 3', 'status = 1']);
        self::$res['data']['user'] = $user_res;

        // 获取第三方检测平台
        $tpm = ThirdPartyMonitoring::getData(['id', 'tpm', 'channel'], ['1=1']);
        self::$res['data']['tpm'] = $tpm;

        // 获取广告主信息
        $ads = Advertiser::getData(['*'], ['id>0']);
        self::$res['data']['ads'] = $ads;

        // 获取平台版本
        self::$res['data']['version'] = Yii::$app->params['DEMAND_PLATFORM'];

        return self::$res;
    }
}