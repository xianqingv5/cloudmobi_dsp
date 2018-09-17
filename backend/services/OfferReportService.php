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
            $result = OfferReporting::getData($fields, $where, self::$groupBy);
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
        $field = Yii::$app->request->get('field', 'click');

        $fields = ['country_id', self::$fieldArr[$field]];
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

            // 查询数据
            $where['offer_id'] = " offer_id in('" . implode("','", $top_offer_ids) . "')";
            $result = OfferReporting::getData(['day', 'offer_id', 'sum(' . $field . ') as '. $field], $where , 'day,offer_id');
            self::$res['status'] = 1;

            // 组装数据
            $r = [];$day = [];
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

                self::$res['data']['day'] = array_keys($default);
                self::$res['data']['data'] = array_values($r);
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
        self::$FillDay = $date;

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