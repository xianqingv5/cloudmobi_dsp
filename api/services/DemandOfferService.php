<?php
namespace api\services;

use Yii;
use common\models\DemandOffers;
use common\models\DemandOffersCreatives;
use common\models\DemandOffersDeliveryCountry;
use common\models\Country;
use common\models\Advertiser;
use common\models\AndroidCategory;
use common\models\IosCategory;

class DemandOfferService extends BaseService
{
    /**
     * 获取offer信息
     * @return array
     */
    public static function getOfferData()
    {
        if (!self::checkToken()) return self::$res;
        $search = self::getWhere();
        if ($search['error']) return self::$res;

        try {
            // 查询offer
            $demand_offer_res = self::getDemandOffer($search['where'], $search['page'], $search['page_size']);
            if ($demand_offer_res) {
                self::$res['status'] = self::$code['success'];
                self::$res['data'] = self::formatData($demand_offer_res);
            } else {
                self::$res['status'] = self::$code['success'];
                self::$res['info'] = 'No Data';
            }
        } catch (\Exception $e) {
            self::$res['status'] = self::$code['server_error'];
            self::$res['info'] = $e->getMessage();
        }

        return self::$res;
    }

    /**
     * 获取demand offer表数据
     * @param $where
     * @param $page
     * @param $page_size
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getDemandOffer($where, $page, $page_size)
    {
        $result   = DemandOffers::find()
            ->asArray()
            ->select(['*'])
            ->where( implode(' and ', $where) )
            ->offset(($page - 1) * $page_size)
            ->limit($page_size)
            ->all();
        return $result ? $result : [];
    }

    /**
     * 组装数据
     * @param $data
     * @return array
     */
    public static function formatData($data)
    {
        $res = [];
        $platform = ['1'=>'ios', '2'=>'Android'];
        $category = self::getCategoryInfo(); // 类型信息

        foreach ($data as $k=>$v) {
            $oid = $v['id'];// offer id

            $res[$k]['id'] = Yii::$app->params['OFFER_ID_STRING'] . str_pad( $v['id'], 3, 0, STR_PAD_LEFT );
            $res[$k]['channel'] = $v['channel'];
            $res[$k]['title'] = $v['title'];
            $res[$k]['pkg'] = $v['pkg_name'];
            $res[$k]['desc'] = $v['desc'];
            $res[$k]['open_type'] = (int)$v['open_type'];
            $res[$k]['payout'] = (float)$v['payout'];
            $res[$k]['tracking_url'] = $v['tracking_url'];
            $res[$k]['final_url'] = $v['final_url'];
            $res[$k]['category'] = $category[ $v['platform'] ][ $v['category_id'] ];
            $res[$k]['daily_cap'] = (int)$v['daily_cap'];
            $res[$k]['daily_cap'] = (int)$v['daily_cap'];
            $res[$k]['status'] = (int)$v['status'];
            $res[$k]['platform'] = $platform[ $v['platform'] ];
            $res[$k]['device_target'] = $v['device_target'];
            $res[$k]['min_osv'] = $v['min_os_version'];
            $res[$k]['att_pro'] = (int)$v['att_pro'];
            $res[$k]['network_environment'] = (int)$v['network_environment'];
            $res[$k]['specific_device'] = ( !empty($v['specific_device']) && $v['specific_device'] != 'null' ) ? json_decode($v['specific_device'], true) : [];

            // 获取广告主信息
            $adv = Advertiser::getDataById($v['sponsor']);
            $res[$k]['sponsor'] = !empty($adv) ? $adv->ads : '';

            // 定点投放国家
            $res[$k]['country'] = trim( implode(',', self::getDeliveryCountry($oid) ) );

            // 素材获取
            $creative = self::getCreativeData($oid);
            $res[$k]['icon'] = isset($creative['icon']) ? $creative['icon'] : [];
            $res[$k]['creatives'] = isset($creative['creatives']) ? $creative['creatives'] : [];
            $res[$k]['videos'] = isset($creative['videos']) ? $creative['videos'] : [];

        }

        return $res;
    }

    public static function getDeliveryCountry($offer_id)
    {
        $data = [];
        $country_all = array_column(self::getCountryData(['id', 'short_name'], ['id>0']), 'short_name', 'id');
        $res = DemandOffersDeliveryCountry::getData(['country_id', 'type'], ["demand_offer_id = '" . $offer_id . "'"]);

        $country = [];
        if (!empty($res)) {
            // 所有国家
            if ($res[0]['type'] == 1) {
                $country = $country_all;
            } else {
                $country_res = [];
                foreach ($res as $k=>$v) {
                    $country_res[] = $country_all[ $v['country_id'] ];
                }

                // 需投放的国家
                if ($res[0]['type'] == 2) {
                    $country = $country_res;
                }

                // 排除的国家
                if ($res[0]['type'] == 3) {
                    $country = array_diff($country_all, $country_res);
                }

            }
        }

        $data = array_values($country);

        return $data;
    }

    /**
     * 获取素材信息
     * @param $offer_id
     * @return array
     */
    public static function getCreativeData($offer_id)
    {
        $data   = [];
        // 定义素材类型
        $creative_type  = [1 => 'icon', 2 => 'creatives', 3 => 'videos'];
        // 查询字段
        $fields = ['width', 'height', 'type', 'url', 'mime_type'];
        // 搜索条件
        $where = [
            "demand_offer_id = '" . $offer_id . "'",
            "status = '1'"
        ];
        // 获取 & 处理数据
        $res    = DemandOffersCreatives::getData($fields, $where);
        if ($res) {
            foreach ($res as $k=>$v) {
                $item = [];
                $item['width'] = (int)$v['width'];
                $item['height'] = (int)$v['height'];
                $item['url'] = $v['url'];

                if ($v['type'] == 3) {
                    $item['type'] = $v['mime_type'];
                    $item['ratio'] = !empty( $item['height'] ) ? (string)round( $item['width'] / $item['height'], 3 ) : (string)0;
                    $item['language'] = 'ALL';
                }

                $data[ $creative_type[$v['type']] ][] = $item;
            }
        }

        return $data;
    }

    /**
     * 获取类型信息
     * @return array
     */
    public static function getCategoryInfo()
    {
        $res = [];
        $fields     =   ['id', 'en_name'];
        $android =  AndroidCategory::getData($fields);
        $ios =  IosCategory::getData($fields);

        $res[1] = array_column($android, 'en_name', 'id');
        $res[2] = array_column($ios, 'en_name', 'id');
        return $res;

    }

    /**
     * 参数获取
     * @return mixed
     */
    private static function getWhere()
    {
        $search['error'] = false;
        $search['where'][] = 'status = 1';

        // 分页
        $page = (int)Yii::$app->request->get('page', 0);
        $page_size = (int)Yii::$app->request->get('page_size', 0);
        if (!$page || !$page_size) {
            $search['error'] = true;
            self::$res['status'] = self::$code['request_error'];
            self::$res['info'] = 'Parameter error';
        }
        $search['page'] = $page;
        $search['page_size'] = $page_size;

        // 投放时间（目前同时生效)
        $delivery_where[]   = 'delivery_start_day <= "' . date('Y-m-d') . '"';// 投放开始时间
        $delivery_where[]   = 'delivery_end_day >= "' . date('Y-m-d') . '"';// 投放结束时间
        $delivery_where[]   = 'delivery_week like "%' . date('w') . '%"';// 投放周
        $delivery_where[]   = 'delivery_hour like "%' . (int)date('H') . '%"';// 投放放小时
        $search['where'][]    = '( delivery_status = 2 OR ( delivery_status = 1 AND ' . implode(' AND ', $delivery_where ) . ' ) )';

        return $search;
    }
}