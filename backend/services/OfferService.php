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
            echo "<pre>";var_dump(Yii::$app->request->post());die;
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
        self::$res['data']['user'] = User::getData(['id', 'email'], ['group_id = 3', 'status = 1']);

        // 获取第三方检测平台
        self::$res['data']['tpm'] = ThirdPartyMonitoring::getData(['id', 'tpm', 'channel'], ['1=1']);

        // 获取广告主信息
        self::$res['data']['ads'] = Advertiser::getData(['*'], ['id>0']);

        // 获取平台版本
        self::$res['data']['version'] = Yii::$app->params['DEMAND_PLATFORM'];

        // 获取国家数据
        self::$res['data']['country'] = CountryService::getCountryAllData(['id', 'full_name', 'short_name'], ['id>0']);

        // 获取应用类别
        self::$res['data']['category'] = CategoryService::getCategoryData(0, ['id', 'en_name as name'], ['parent_id = 0']);

        // 获取设备信息
        self::$res['data']['mobile'] = Yii::$app->params['MOBILE'];
        return self::$res;
    }
}