<?php
namespace backend\services;

use Yii;
use common\models\DemandOffers;
use common\models\OfferReporting;
use common\models\User;

class OfferReportService extends BaseService
{
    // 返回结果数组
    public static $res = ['status'=>0, 'info'=>'', 'data'=>[]];

    // 图表查询字段配置
    private static $fieldArr = [
        'click' => 'sum(click) as click',
        'conversion' => 'sum(conversion) as conversion',
        'payout' => 'sum(payout) as payout',
        'cvr' => 'sum(conversion) / sum(click) as cvr'
    ];

    // 日期
    private static $FillDay = [];

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
            $result = OfferReporting::getData($fields, $where, 'day');
            self::$res['status'] = 1;

            // 默认值填充
            $r = [];
            $default = self::dataFillEmpty(['click', 'conversion', 'payout', 'cvr']); // x、y 轴默认值
            $r['day'] = array_keys($default);
            if ($result) {
                foreach ($result as $k=>$v) {
                    $default[$v['day']]['click'] = (int)$v['click'];
                    $default[$v['day']]['conversion'] = (int)$v['conversion'];
                    $default[$v['day']]['payout'] = (int)$v['payout'];
                    $default[$v['day']]['cvr'] = (float)$v['cvr'];
                }
            }

            self::$res['data']['day'] = array_keys($default);
            self::$res['data']['click'] = array_column($default, 'click');
            self::$res['data']['conversion'] = array_column($default, 'conversion');
            self::$res['data']['payout'] = array_column($default, 'payout');
            self::$res['data']['cvr'] = array_column($default, 'cvr');
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
        $field = Yii::$app->request->get('field', 'conversion');

        $fields = ['country_id', self::$fieldArr[$field]];
        $orderBy = $field . ' DESC ';
        $country_res = self::getCountryData(['id', 'full_name as country_name']);
        $country = array_column($country_res, 'country_name', 'id');

        try {
            $where = self::getWhere();
            $result = OfferReporting::getData($fields, $where, 'country_id', $orderBy, 10, false);

            $r = [];
            if ($result) {
                self::$res['status'] = 1;
                foreach ($result as $k=>$v) {
                    $r['name'][] = isset($country[$v['country_id']]) ? $country[$v['country_id']] : $country[0];
                    $r['fields'][] = (float)$v[$field];
                }

                self::$res['data'] = $r;
            } else {
                self::$res['info'] = 'No Data';
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'No Data';
        }

        return self::$res;
    }

    /**
     * offer top 10 折线图数据提供
     * @return array
     */
    public static function getOfferTopLine()
    {
        try {
            $field = Yii::$app->request->get('field', 'conversion');
            $where = self::getWhere();

            // top 5 offer_id
            $offer_res = OfferReporting::getData(['offer_id', self::$fieldArr[$field]], $where, 'offer_id', $field . ' desc', 5);
            $top_offer_ids = !empty($offer_res) ? array_column($offer_res, 'offer_id') : [0];

            // 查询数据
            $where['offer_id'] = " offer_id in('" . implode("','", $top_offer_ids) . "')";

            $result = OfferReporting::getData(['day', 'offer_id', self::$fieldArr[$field]], $where , 'day,offer_id', '', '', false);

            // 组装数据
            $r = [];
            if ($result) {
                $offer_ids = array_unique(array_column($result, 'offer_id'));
                $default = self::dataFillEmpty($offer_ids);
                // 循环赋值
                foreach ($result as $k=>$v) {
                    $default[$v['day']][$v['offer_id']] = $v[$field];

                }
                // 组装数据
                foreach ($default as $key=>$val) {
                    foreach ($val as $k=>$v) {
                        $r[$k]['name'] = $k;
                        $r[$k]['data'][] = (float)$v;
                    }
                }
                self::$res['status'] = 1;
                self::$res['data']['day'] = array_keys($default);
                self::$res['data']['data'] = array_values($r);
            } else {
               self::$res['info'] = 'No Data';
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'No Data';
        }

        return self::$res;
    }

    /**
     * 搜索条件
     * @return mixed
     */
    public static function getWhere()
    {
        // day
        $date = Yii::$app->request->get('date', [date('Y-m-d', strtotime('-6 days')), date('Y-m-d')]);
        $where['day'] = "day between '" . $date[0] . "' and '" . $date[1] . "'";
        self::$FillDay = $date;

        // campaign owner
        if (self::isAdvertiserAgent()) {
            $uid = Yii::$app->user->identity->id;
            $where['campaign_owner'] = "campaign_owner = '" . $uid . "'";
        } else if (self::isSuperAdmin() || self::isAdmin()) {
            $campaign_owner = Yii::$app->request->get('campaigns_owner', []);
            if ($campaign_owner) {
                $where['campaign_owner'] = "campaign_owner in ('" . ( is_array($campaign_owner) ? implode(',',$campaign_owner) : [0] ) . "')";
            }
        }

        // campaign
        $offer_ids = Yii::$app->request->get('campaigns', []);
        if ($offer_ids) {
            $where['offer_id'] = "offer_id in('" . ( is_array($offer_ids) ? implode("','", $offer_ids) : [0] ) ."')";
        }

        // country
        $country_ids = Yii::$app->request->get('country', []);
        if ($country_ids) {
            $where['country_id'] = "country_id in(" . ( is_array($country_ids) ? implode(',', $country_ids) : [0] ) . ")";
        }

        return $where;

    }

    /**
     * offer report 搜索框数据获取
     * @return array
     */
    public static function getOfferSearch()
    {
        try {

            // offer campaigns
            $where = [];
            // 广告代理商
            if (self::isAdvertiserAgent()) {
                $where['campaign_owner'] = "campaign_owner = '" . Yii::$app->user->identity->id . "'";;
            }
            // 查询数据
            $result = DemandOffers::getData(['id', 'channel', 'offer_id'], $where);
            self::$res['data']['campaigns'] = [];
            if ($result) {
                // offer id 组装
                self::$res['status'] = 1;
                foreach ($result as $k=>$v) {
                    self::$res['data']['campaigns'][$k]['name'] = Yii::$app->params['THIRD_PARTY'][$v['channel']] . $v['offer_id'];
                    self::$res['data']['campaigns'][$k]['id'] = $v['id'];
                }
            }

            // country
            self::$res['data']['country'] = array_column(self::getCountryData(['id', 'full_name as country_name'], ['id>0']), 'country_name', 'id');

            // campaigns owner
            self::$res['data']['campaigns_owner'] = [];
            if (self::isSuperAdmin() || self::isAdmin()) {
                $res = User::getData(['email','id'], ['group_id = 3']);
                if ($res) {
                    self::$res['data']['campaigns_owner'] = array_column($res, 'email', 'id');
                }
            }

            //
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            self::$res['info'] = 'No Data';
        }

        return self::$res;
    }

    /**
     * 没有数据时,数据填充
     * @param array $fields
     * @return array
     */
    public static function dataFillEmpty($fields = [])
    {
        $data = [];
        $date = self::$FillDay[0];
        while($date <= self::$FillDay[1]) {
            if (!empty($fields)) {
                foreach ($fields as $v) {
                    $data[$date][$v] = 0;
                }
            } else {
                $data[$date] = 0;
            }

            $date = date('Y-m-d',strtotime($date) + 24 * 3600);
        }
        return $data;
    }
}