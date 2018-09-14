<?php
namespace backend\services;

use Yii;
use common\models\OfferReporting;

class OfferReportService extends BaseService
{
    // 返回结果数组
    public static $res = ['status'=>0, 'info'=>'', 'data'=>[]];

    // 查询分组
    private static $groupBy = 'day';

    /**
     * 获取offer 报表折线数据
     * @return array
     */
    public static function getOfferReportData()
    {
        try {
            $where = self::getWhere();
            $fields = [
                'day',
                'sum(click) as click',
                'sum(conversion) as conversion',
                'sum(payout) as payout',
                'sum(conversion) / sum(click) as cvr'
            ];
            $result = OfferReporting::getData($fields, $where, self::$groupBy);
            self::$res['status'] = 1;
            $r = [];
            if ($result) {
                foreach ($result as $k=>$v) {
                    $r['day'][] = $v['day'];
                    $r['click'][] = (int)$v['click'];
                    $r['conversion'][] = (int)$v['conversion'];
                    $r['payout'][] = (float)$v['payout'];
                    $r['cvr'][] = (float)$v['cvr'];
                }
                self::$res['data'] = $r;
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'No Data';
        }

        return self::$res;

    }

    /**
     * 获取国家top 10 柱状图
     * @return array
     */
    public static function getCountryTopBar()
    {
        $field = Yii::$app->request->get('field', 'click');
        $fields = ['country_id', "sum(" . $field . ") as " . $field];
        $orderBy = $field . ' DESC ';
        $country_res = self::getCountryData(['id', 'full_name as country_name']);
        $country = array_column($country_res, 'country_name', 'id');

        try {
            $where = self::getWhere();
            $result = OfferReporting::getData($fields, $where, 'country_id', $orderBy, 10, false);
            self::$res['status'] = 1;
            $r = [];
            if ($result) {
                foreach ($result as $k=>$v) {
                    $r['name'][] = isset($country[$v['country_id']]) ? $country[$v['country_id']] : $country[0];
                    $r['fields'][] = (float)$v[$field];
                }

                self::$res['data'] = $r;
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'No Data';
        }

        return self::$res;
    }

    public static function getOfferTopLine()
    {
        try {
            $field = Yii::$app->request->get('field', 'click');
            $where = self::getWhere();

            // top 10 offer_id
            $offer_res = OfferReporting::getData(['offer_id', 'sum(' . $field . ') as f'], $where, 'offer_id', ' f desc', 10);
            $top_offer_ids = !empty($offer_res) ? array_column($offer_res, 'offer_id') : [0];

            $where['offer_id'] = " offer_id in('" . implode("','", $top_offer_ids) . "')";
            $result = OfferReporting::getData(['day', 'offer_id', 'sum(' . $field . ') as '. $field], $where , 'day,offer_id');
            self::$res['status'] = 1;
            $r = [];$day = [];
            if ($result) {
                foreach ($result as $k=>$v) {
                    $day[$v['day']] = $v['day'];
                    //if (isset())
                    $r[$k]['name'] = $v['offer_id'];
                    $r[$k]['data'][] = (float)$v[$field];
                }

                self::$res['data']['data'] = $r;
                self::$res['data']['day'] = array_values($day);
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'No Data';
        }

        return self::$res;
    }

    public static function getWhere()
    {
        // day
        $date = Yii::$app->request->get('date', [date('Y-m-d', strtotime('-6 days')), date('Y-m-d')]);
        $where['day'] = "day between '" . $date[0] . "' and '" . $date[1] . "'";

        // campaign owner
        if (self::isAdvertiserAgent()) {
            $uid = Yii::$app->user->identity->id;
            $where['campaign_owner'] = "campaign_owner = '" . $uid . "'";
        } else {
            $campaign_owner = Yii::$app->request->get('campaignsOwner', []);
            if ($campaign_owner) {
                $where['campaign_owner'] = "campaign_owner in ('" . implode(',',$campaign_owner) . "')";
            }
        }

        // campaign
        $offer_ids = Yii::$app->request->get('campaigns', []);
        if ($offer_ids) {
            $where['offer_id'] = "offer_id in('" . implode("','", $offer_ids) ."')";
        }

        // country
        $country_ids = Yii::$app->request->get('country', []);
        if ($country_ids) {
            $where['country_id'] = "country_id in(" . implode(',', $country_ids) . ")";
        }

        return $where;

    }
}