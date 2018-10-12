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

    CONST PAGE_SIZE = 50;// 每页条数

    /**
     * offer 列表数据获取
     * @return array
     */
    public static function getOfferList()
    {
        $where = self::getWhere();
        $fields = ['id', 'channel', 'campaign_owner', 'offer_id', 'title', 'payout', 'delivery_price', 'status', 'platform'];
        // 查询总条数
        $res_count = DemandOffers::getData(['count(*) as num'], $where);

        // 分页
        $page = Yii::$app->request->post('page', 1);
        $page_size = Yii::$app->request->post('page_size', self::PAGE_SIZE);
        $page2 = ($page > 0) ? $page - 1 : 0;
        $limit =  $page2 . "," . $page_size;

        $res = DemandOffers::getData($fields, $where, '', 'update_date desc,status desc', $limit);
        if ($res) {
            foreach ($res as $k=>$v) {
                $res[$k]['show_offer_id'] =  Yii::$app->params['THIRD_PARTY'][$v['channel']] . $v['offer_id'];
            }
            self::$res['status'] = 1;
            self::$res['data'] = $res;
            self::$res['page']['count'] = $res_count[0]['num'];// 总条数
            self::$res['page']['page_size'] = $page_size;// 每页条数
            self::$res['page']['page'] = $page;// 当前页
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
        // 是否是代理广告商
        if (Yii::$app->user->identity->group_id == 3) {
            $where['campaign_owner'] = "campaign_owner = '" . Yii::$app->user->identity->id . "'";
        } else {
            $campaign_owner = Yii::$app->request->post('campaign_owner', 0);
            if ($campaign_owner) {
                $where['campaign_owner'] = "campaign_owner = '" . $campaign_owner . "'";
            }
        }

        // search campaign id
        $offer_id = Yii::$app->request->post('offer_id', '');
        if ($offer_id) {
            $id =  (int)trim(strstr($offer_id, Yii::$app->params['OFFER_ID_STRING']), Yii::$app->params['OFFER_ID_STRING']);
            $where['offer'] = "id = '" . $id . "'";
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
            $where['title'] = "title like '%" . $title . "%'";
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
        // 页面显示offer id 组装
        // self::$res['data']['show_offer_id'] = $offer[0]['channel'] . '_' . Yii::$app->params['OFFER_ID_STRING'] . str_pad( $offer[0]['id'], 3, 0, STR_PAD_LEFT );
        self::$res['data']['show_offer_id'] = Yii::$app->params['THIRD_PARTY'][$offer[0]['channel']] . $offer[0]['offer_id'];
        // 数据转换
        $delivery_hour = !empty($offer[0]['delivery_hour']) ? json_decode($offer[0]['delivery_hour'], true) : [];
        $d_hour = [];
        if ($delivery_hour && is_array($delivery_hour)) {
            foreach ($delivery_hour as $v) {
                $d_hour[] = str_pad($v, 2, 0, STR_PAD_LEFT);
            }
        }
        self::$res['data']['delivery_hour'] = $d_hour;

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
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // offer 添加
            $demand_offer_id = self::addDemandOffer();
            if (!$demand_offer_id) {
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
            //self::$res['info'] = 'offer create fail.';
            self::$res['info'] = $e->getMessage();
            $transaction->rollBack();
        }

        return self::$res;
    }

    public static function updateOfferData()
    {
        $offer_id = Yii::$app->request->post('offer_id', 0);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // demand offer update
            $demand_offer = self::updateDemandOffer($offer_id);

            // del offer 素材
            $del_offer_file = self::delOfferFile($offer_id);

            // offer 素材 添加
            $add_offer_file = self::addOfferFile($offer_id);

            // offer 投放国家删除
            $del_offer_country = self::delOfferCountryData($offer_id);

            // offer 投放国家添加
            $add_offer_country = self::addOfferCountryData($offer_id);

            // commit
            if ($demand_offer && $del_offer_file && $add_offer_file && $del_offer_country && $add_offer_country) {
                self::$res['status'] = 1;
                self::$res['info'] = 'success';
                $transaction->commit();
            }

        } catch (\Exception $e) {
            self::logs($e->getMessage());
            //self::$res['info'] = 'offer update fail.';
            self::$res['info'] = $e->getMessage();
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

        $data = self::getPostInfo();

        // 生成offer id
        do {
            $offer_id = self::generateOfferId();
            $num = DemandOffers::getData(['count(*) as num'], ["offer_id = '" . $offer_id . "'"])[0]['num'];
        } while($num);
        $data['offer_id'] = $offer_id;

        $data['status'] = (self::isSuperAdmin() || self::isAdmin()) ? 1 : 3; // 如果是管理员创建状态为开启,否则状态为未审核
        $data['create_date'] = date('Y-m-d H:i:s');
        $offer_id = DemandOffers::addData($data);
        return $offer_id;
    }

    public static function updateDemandOffer($offer_id)
    {
        $status = Yii::$app->request->post('status', 1);
        $data = self::getPostInfo();
        $data['status'] = (self::isSuperAdmin() || self::isAdmin()) ? $status : 3;
        $res = DemandOffers::updateData($data, ['id' => $offer_id]);
        return $res;

    }

    /**
     * 组装post提交数据
     * @return mixed
     */
    private static function getPostInfo()
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
        $data['daily_cap'] = !empty(Yii::$app->request->post('daily_cap', -1)) ? Yii::$app->request->post('daily_cap', -1) : -1;
        $data['total_cap'] = !empty(Yii::$app->request->post('total_cap', -1)) ? Yii::$app->request->post('total_cap', -1) : -1;
        $data['platform'] = Yii::$app->request->post('platform', 0);
        $data['device_target'] = Yii::$app->request->post('device_target', '');
        $data['min_os_version'] = Yii::$app->request->post('min_os_version', '');
        $data['sponsor'] = Yii::$app->request->post('sponsor', '');
        $data['att_pro'] = Yii::$app->request->post('att_pro', 0);
        $data['network_environment'] = Yii::$app->request->post('network_environment', '3');
        $data['comment'] = Yii::$app->request->post('comment', '');

        // 投放价格
        $delivery_price = Yii::$app->request->post('delivery_price', 0);
        if ($delivery_price) {
            $data['delivery_price'] = $delivery_price;
        }

        // impression url
        $impression_url = Yii::$app->request->post('impression_url', []);
        $data['impression_url'] = json_encode($impression_url);

        // 投放时间
        $data['delivery_status'] = Yii::$app->request->post('delivery_status', 2);
        $data['delivery_start_day'] = Yii::$app->request->post('delivery_start_data', date('Y-m-d'));
        $data['delivery_end_day'] = Yii::$app->request->post('delivery_end_data', date('Y-m-d', strtotime('+14 days')));
        $delivery_week = array_map(function ($n) {
            return (int)$n;
        }, Yii::$app->request->post('delivery_week', []) );
        $delivery_hour = array_map(function ($n) {
            return (int)$n;
        }, Yii::$app->request->post('delivery_hour', []) );
        $data['delivery_week'] = json_encode($delivery_week);
        $data['delivery_hour'] = json_encode($delivery_hour);

        // 设备机型
        $data['specific_device'] = json_encode(Yii::$app->request->post('specific_device'));

        $data['update_date'] = date('Y-m-d H:i:s');

        return $data;
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
        $icon_res = Yii::$app->request->post('icon', []);
        $icon = [];
        if ($icon_res && is_array($icon_res)) {
            $icon[0]['demand_offer_id'] = $offer_id;
            $icon[0]['url'] = $icon_res[0]['url'];
            $icon[0]['width'] = $icon_res[0]['width'];
            $icon[0]['height'] = $icon_res[0]['height'];
            $icon[0]['mime_type'] = $icon_res[0]['mime_type'];
            $icon[0]['type'] = 1;
            $icon[0]['status'] = 1;
            $icon[0]['create_date'] = $date;
            $icon[0]['update_date'] = $date;
        }

        // image
        $image_res = Yii::$app->request->post('image', []);
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
        $video_res = Yii::$app->request->post('video', []);
        $video = [];
        if ($video_res) {
            foreach ($video_res as $k=>$v) {
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
        $res = DemandOffersCreatives::addAllData($data);
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
        $country_res = Yii::$app->request->post('country', []);

        $data = [];
        if ($country_type && $country_type != 1 && $country_res) {
            foreach ($country_res as $k=>$v) {
                $data[$k]['demand_offer_id'] = $offer_id;
                $data[$k]['country_id'] = $v;
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
     * @param $offer_id
     * @return array
     */
    public static function delOfferCountryData($offer_id) {
        $res = DemandOffersDeliveryCountry::deleteData(['demand_offer_id'=>$offer_id]);
        if ($res) {
            self::$res['status'] = 1;
            self::$res['info'] = 'success';
        } else {
            self::$res['info'] = 'fail';
        }
        return self::$res;
    }

    /**
     * 删除offer素材
     * @param $offer_id
     * @return array
     */
    public static function delOfferFile($offer_id)
    {
        $res = DemandOffersCreatives::deleteData(['demand_offer_id'=>$offer_id]);
        if ($res) {
            self::$res['status'] = 1;
            self::$res['info'] = 'success';
        } else {
            self::$res['info'] = 'fail';
        }
        return self::$res;
    }

    /**
     * 根据offer id 状态 修改
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
     * 根据用户id 修改offer状态
     * @param $uid
     * @param int $status
     * @return bool
     */
    public static function updateOfferStatusByUser($uid, $status = 2)
    {
        $res = DemandOffers::updateData(['status' => $status], ['campaign_owner' => $uid]);
        return $res ? true : false;
    }

    /**
     * 生成offer id
     * 规则: Account简称 + _ + 10位编号(日月年 + 4位随机数。例:0810181234)
     * @return string
     */
    public static function generateOfferId()
    {
        $uid = Yii::$app->request->post('campaign_owner', 0);
        $uInfo = User::findIdentity($uid);
        $short_name = !empty($uInfo) ? $uInfo->short_name : '';
        $offer_id = $short_name . '_' . date('dmy') . rand(1000, 9999);
        return $offer_id;
    }

    /**
     * 获取offer各种配置信息
     * @return array
     */
    public static function getOfferConfig()
    {
        // 获取offer所属者
        self::$res['data']['user'] = User::getData(['id', 'email', 'status'], ['group_id = 3']);

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

        // 获取用户状态
        self::$res['data']['user_status'] = UserService::getUserStatus();
        return self::$res;
    }
}