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
     * demand offer table 添加数据
     * @return int|string
     */
    public static function addDemandOffer()
    {
        $data['channel'] = Yii::$app->request->post('channel', '');
        $data['campaign_owner'] = Yii::$app->request->post('campaign_owner', 0);
        $data['title'] = Yii::$app->request->post('title', '');
        $data['pkg_name'] = Yii::$app->request->post('pkg_name', '');
        $data['desc'] = Yii::$app->request->post('desc', '');
        $data['payout'] = Yii::$app->request->post('payout', 0);
        $data['tracking_url'] = Yii::$app->request->post('tracking_url', '');
        $data['final_url'] = Yii::$app->request->post('final_url', '');
        $data['category_id'] = Yii::$app->request->post('category_id', 0);
        $data['daily_cap'] = Yii::$app->request->post('daily_cap', -1);
        $data['total_cap'] = Yii::$app->request->post('total_cap', -1);
        $data['platform'] = Yii::$app->request->post('platform', 0);
        $data['device_target'] = Yii::$app->request->post('device_target', '');
        $data['min_os_version'] = Yii::$app->request->post('min_os_version', '');
        $data['sponsor'] = Yii::$app->request->post('sponsor', '');
        $data['att_pro'] = Yii::$app->request->post('att_pro', 0);
        $data['network_environment'] = Yii::$app->request->post('network_environment', '3');
        $data['comment'] = Yii::$app->request->post('comment', '');

        // 投放时间
        $data['delivery_status'] = Yii::$app->request->post('delivery_status', 2);
        $data['delivery_start_day'] = Yii::$app->request->post('delivery_start_day', '');
        $data['delivery_end_day'] = Yii::$app->request->post('delivery_end_day', '');
        $data['delivery_week'] = Yii::$app->request->post('delivery_week', '');
        $data['delivery_hour'] = Yii::$app->request->post('delivery_hour', '');

        // 设备机型
        $data['specific_device'] = json_encode(Yii::$app->request->post('specific_device'));

        $data['status'] = 1; // open
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['update_date'] = date('Y-m-d H:i:s');

        $offer_id = DemandOffers::addData($data);
        return $offer_id;
    }

    public static function addOfferFile($offer_id)
    {
        // icon
        //$data[]
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