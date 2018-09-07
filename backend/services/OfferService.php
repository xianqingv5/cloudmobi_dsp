<?php
namespace backend\services;

use Yii;
use common\models\User;
use common\models\ThirdPartyMonitoring;
use common\models\Advertiser;
use common\models\DemandOffers;
use common\models\DemandOffersCreatives;
use common\models\DemandOffersDeliveryCountry;

class OfferService extends BaseService
{
    public static $res = ['status'=>0, 'info'=>'', 'data'=>[]];

    /**
     * offer 列表数据获取
     * @return array
     */
    public static function getOfferList()
    {
        $where = self::getWhere();
        $res = DemandOffers::getData(['id', 'channel', 'title', 'payout', 'status'], $where);
        if ($res) {
            self::$res['status'] = 1;
            self::$res['data'] = $res;
        } else {
            self::$res['info'] = 'No Data';
        }

        return self::$res;
    }

    /**
     * 搜索条件
     * @return array
     */
    private static function getWhere()
    {
        $where = [];

        // search campaign id
        $offer_id = Yii::$app->request->post('offer_id', 0);
        if ($offer_id) {
            $where['offer'] = "id = '" . $offer_id . "'";
        }
        // search advertiser
        $sponsor = Yii::$app->request->post('sponsor', '');
        if ($sponsor) {
            $where['sponsor'] = "sponsor = '" . $sponsor . "'";
        }

        // search status
        $status = Yii::$app->request->post('status', 0);
        if ($status) {
            $where['status'] = "status = '" . $status . "'";
        }

        // search title
        $title = Yii::$app->request->post('title', '');
        if ($title) {
            $where['title'] = "title = '" . $title . "'";
        }

        return $where;
    }

    /**
     * offer 修改 数据获取
     * @return array
     */
    public static function getDemandOfferData()
    {
        $offer_id = Yii::$app->request->post('offer_id', 0);
        // 获取demand offer
        $offer = DemandOffers::getData(['*'], ["id='" . $offer_id . "'"]);
        if (!$offer) {
            self::$res['info'] = 'No data';
            return self::$res;
        }

        self::$res['data'] = $offer[0];

        // 获取offer 素材
        $offer_file = DemandOffersCreatives::getData(['id', 'url', 'mime_type', 'width', 'height', 'size', 'type'], ["demand_offer_id='" . $offer_id . "'"]);
        if ($offer_file) {
            foreach ($offer_file as $k=>$v) {
                if ($v['type'] == 1) { // icon
                    self::$res['data']['icon'] = $v;
                } else if ($v['type'] == 2) { // image
                    self::$res['data']['image'][] = $v;
                } else if ($v['type'] == 3) { // video
                    self::$res['data']['video'][] = $v;
                }
            }
        }

        // offer 投放国家
        $offer_country = DemandOffersDeliveryCountry::getData(['country_id', 'type'], ["demand_offer_id='" . $offer_id . "'"]);
        if ($offer_country) {
            foreach ($offer_country as $k=>$v) {
                if ($v['type'] == 1) {
                    self::$res['data']['country_type'] = 1;
                    self::$res['data']['country'] = [];
                } else {
                    self::$res['data']['country_type'] = $v['type'];
                    self::$res['data']['country'][] = $v['country_id'];
                }
            }
        }

        return self::$res;
    }

    /**
     * offer 各种数据添加
     * @return array
     */
    public static function addOfferData()
    {
        // 验证参数
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // offer 添加
            $demand_offer_id = self::addDemandOffer();
            if ($demand_offer_id) {
                self::$res['info'] = 'offer create fail.';
                return self::$res;
            }
            // offer下的素材添加
            $offer_file = self::addOfferFile($demand_offer_id);

            // offer投放国家添加
            $offer_country = self::addOfferCountryData($demand_offer_id);

            if ($demand_offer_id && $offer_file && $offer_country) {
                self::$res['status'] = 1;
                self::$res['info'] = 'success';
                $transaction->commit();
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'offer create fail.';
            $transaction->rollBack();
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

        $data['status'] = in_array(Yii::$app->user->identity->group_id, [1,2]) ? 1 : 3; // 如果是管理员创建状态为开启,否则状态为未审核
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['update_date'] = date('Y-m-d H:i:s');

        $offer_id = DemandOffers::addData($data);
        return $offer_id;
    }

    /**
     * offer 素材添加
     * @param $offer_id
     * @return int|string
     */
    public static function addOfferFile($offer_id)
    {
        $date = date('Y-m-d H:i:s');
        // icon
        $icon_res = json_decode(Yii::$app->request->post('icon', []));
        $icon = [];
        if ($icon_res) {
            $icon['demand_offer_id'] = $offer_id;
            $icon['url'] = $icon_res['url'];
            $icon['width'] = $icon_res['width'];
            $icon['height'] = $icon_res['height'];
            $icon['mime_type'] = $icon_res['type'];
            $icon['type'] = 1;
            $icon['status'] = 1;
            $icon['create_date'] = $date;
            $icon['update_date'] = $date;
        }

        // image
        $image_res = json_decode(Yii::$app->request->post('image', []));
        $image = [];
        if ($image_res) {
            foreach ($image_res as $k=>$v) {
                $image[$k]['demand_offer_id'] = $offer_id;
                $image[$k]['url'] = $v['url'];
                $image[$k]['width'] = $v['width'];
                $image[$k]['height'] = $v['height'];
                $image[$k]['mime_type'] = $v['mime_type'];
                $image[$k]['type'] = 2;
                $image[$k]['status'] = 1;
                $image[$k]['create_date'] = $date;
                $image[$k]['update_date'] = $date;
            }
        }

        // video
        $video_res = json_decode(Yii::$app->request->post('video', []));
        $video = [];
        if ($video_res) {
            foreach ($image_res as $k=>$v) {
                $video[$k]['demand_offer_id'] = $offer_id;
                $video[$k]['url'] = $v['url'];
                $video[$k]['width'] = $v['width'];
                $video[$k]['height'] = $v['height'];
                $video[$k]['mime_type'] = $v['mime_type'];
                $video[$k]['type'] = 3;
                $video[$k]['status'] = 1;
                $video[$k]['create_date'] = $date;
                $video[$k]['update_date'] = $date;
            }
        }

        $data = array_merge($icon, $image, $video);
        $res = DemandOffersCreatives::addData($data);
        return $res;

    }

    /**
     * offer 投放国家 添加
     * @param $offer_id
     * @return int|string
     */
    public static function addOfferCountryData($offer_id)
    {
        $date = date('Y-m-d H:i:s');
        $country_type = Yii::$app->request->post('country_type', 0);
        $country_res = json_decode(Yii::$app->request->post('country', []));

        $data = [];
        if ($country_type && $country_type != 1 && $country_res) {
            foreach ($country_res as $k=>$v) {
                $data[$k]['demand_offer_id'] = $offer_id;
                $data[$k]['country_id'] = $v['id'];
                $data[$k]['type'] = $country_type;
                $data[$k]['create_date'] = $date;
                $data[$k]['update_date'] = $date;
            }
        } else { // all country
            $data[0]['demand_offer_id'] = $offer_id;
            $data[0]['country_id'] = 0;
            $data[0]['type'] = 1;
            $data[0]['create_date'] = $date;
            $data[0]['update_date'] = $date;
        }

        $res = DemandOffersDeliveryCountry::addAllData($data);
        return $res;
    }

    /**
     * offer 投放国家 删除
     * @return array
     */
    public static function delOfferCountryData() {
        $offer_id = Yii::$app->request->post('offer_id', 0);
        $res = DemandOffersDeliveryCountry::deleteData(['demand_offer_id'=>$offer_id]);
        if ($res) {
            self::$res['status'] = 1;
            self::$res['info'] = 'success';
        } else {
            self::$res['info'] = 'fail';
        }
        return self::$res;
    }

    public static function delOfferFile()
    {
        $id = Yii::$app->request->post('id', 0);
        $res = DemandOffersCreatives::deleteData(['id'=>$id]);
        if ($res) {
            self::$res['status'] = 1;
            self::$res['info'] = 'success';
        } else {
            self::$res['info'] = 'fail';
        }
        return self::$res;
    }

    /**
     * offer 状态 修改
     * @return array
     */
    public static function updateOfferStatus()
    {
        $offer_id = Yii::$app->request->post('offer_id', 0);
        $status = Yii::$app->request->post('status', 1);
        $res = DemandOffers::updateData(['status' => $status], ['id' => $offer_id]);
        if ($res) {
            self::$res['status'] = 1;
            self::$res['info'] = 'success';
        } else {
            self::$res['info'] = 'fail';
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