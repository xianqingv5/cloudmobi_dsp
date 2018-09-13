<?php

namespace console\services;

use Yii;
use common\models\OfferReporting;
use common\models\DemandOffers;
use common\models\Country;

class OfferReportingServices
{
    CONST OFFER_URL = 'http://10.17.6.37:9987/get/dsp_offers';

    /**
     * 拉取数据
     * @param $params
     * @return array|mixed
     */
    public static function getData($params)
    {
        $query = '?' . http_build_query($params);

        $res = self::sendRequest(self::OFFER_URL . $query);

        return !empty($res) ? json_decode($res, true) : [];
    }

    /**
     * 执行拉取数据
     * @param $url
     * @return string
     */
    public static function sendRequest($url)
    {
        return file_get_contents($url);
    }

    public static function insertData($data){
        if (empty($data) || !is_array($data)) return false;

        $time = date('Y-m-d H:i:s');

        $platform_type = \Yii::$app->params['PLATFORM_TYPE'];

        foreach ($data as $k => $v){
            $country = Country::getData(['id'],["short_name = '" . $v['country'] ."'"]);
            $info[$k]['date'] = $v['date'];
            $info[$k]['offer_id'] = $v['offer_id'];
            $info[$k]['country'] = $country[0]['id'];
            $info[$k]['platform'] = $platform_type[$v['platform']];
            $info[$k]['click'] = $v['click'];
            $info[$k]['conversion'] = $v['conversion'];
            $info[$k]['payout'] = $v['payout'];
            $info[$k]['create_date'] = $time;
        }

        $data_chunk = array_chunk($info, 100);
        foreach ($data_chunk as $key=>$val) {
            $start = microtime(true);
            $result = OfferReporting::batchInsertAndUpdate($val);
            $end   = microtime(true);
            echo ($result != false) ? " 第 " . ($key + 1) . " 页数据插入成功---耗时:" . ($end - $start) . "\n" : " 第 " . $key . " 页数据插入失败耗时:" . ($end - $start) . "\n";
        }
    }

    public static function getOfferId($offer_id,$user_id){
        $fields = ['id','channel'];

        $where = [];
        if($offer_id){
            $where[] = "id = '". $offer_id . "'";
        }

        if($user_id){
            $where[] = "campaign_owner = '" . $user_id . "'";
        }

        $offer = DemandOffers::getData($fields,$where);
        if($offer){
            $data = [];
            foreach ($offer as $k => $v) {
                $data[$k] = $v['channel'] . '_' . 'offline' . str_pad( $v['id'], 3, 0, STR_PAD_LEFT );
            }
            return $data;
        }else{
            return false;
        }
    }

    public static function getDateFromRange($st, $et){

        $stimestamp = strtotime($st);
        $etimestamp = strtotime($et);

        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d', $stimestamp+(86400*$i));
        }

        return $date;
    }

}