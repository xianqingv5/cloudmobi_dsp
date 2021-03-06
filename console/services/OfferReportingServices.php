<?php

namespace console\services;

use Yii;
use common\models\OfferReporting;
use common\models\DemandOffers;
use common\models\Country;
use yii\log\Logger;

class OfferReportingServices
{
    CONST OFFER_URL = 'http://10.17.6.37:9987/get/dsp_offers';//内网
//    CONST OFFER_URL = 'http://dash.cloudmobi.net:9987/get/dsp_offers';//外网
    CONST SIZE = 100;

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
        $content = '';
        //设置超时时间和方法
        $opts = [
            'http'  =>  [
                'method'=>"GET",
                'timeout'=>30,//单位秒
            ],
        ];

        $st = microtime(true);
        //设置尝试次数
        $cnt=0;
        while($cnt<3 && ($content=@file_get_contents($url, 0, stream_context_create($opts)))===FALSE)
        {
            echo "拉取数据失败。url:" . $url . "\n";
            $cnt++;
        }
        $et = microtime(true);
        echo "-耗时:" . ($et - $st) . "\n";

        return $content;
    }

    /**
     * @param $data
     * @return bool
     */
    public static function insertData($data){
        if (empty($data) || !is_array($data)) return false;

        $time = date('Y-m-d H:i:s');

        $platform_type = \Yii::$app->params['PLATFORM_TYPE'];

        try {
            $info = [];
            foreach ($data as $k => $v) {
                $country = Country::getData(['id'], ["short_name = '" . $v['country'] . "'"]);
                $info[$k]['day'] = $v['date'];
                $info[$k]['campaign_owner'] = $v['campaign_owner'];
                $info[$k]['offer_id'] = $v['offer_id'];
                $info[$k]['country_id'] = isset($country[0]['id']) ? $country[0]['id'] : 0;
                $info[$k]['platform'] = isset($platform_type[strtolower($v['platform'])]) ? $platform_type[strtolower($v['platform'])] : 3;
                $info[$k]['click'] = isset($v['click']) ? $v['click'] : 0;
                $info[$k]['conversion'] = isset($v['conversion']) ? $v['conversion'] : 0;
                $info[$k]['payout'] = isset($v['payout']) ? $v['payout'] : 0;
                $info[$k]['create_date'] = $time;
            }

            $data_chunk = array_chunk($info, 100);
            foreach ($data_chunk as $key => $val) {
                $result = OfferReporting::batchInsertAndUpdate($val);
            }
        } catch (\Exception $e) {
            echo $e . "\n";
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
        }
    }

    /**
     * 获取offer id
     * @param $offer_id
     * @param $user_id
     * @return array|bool
     */
    public static function getOfferId($offer_id,$user_id){
        $fields = ['id','channel','campaign_owner', 'offer_id'];
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
            // 组装数据
            foreach ($offer as $k => $v) {
                $data[$k]['offer_id'] = $v['channel'] . '_' . $v['offer_id'];
                $data[$k]['campaign_owner'] = $v['campaign_owner'];
            }
            return $data;
        }else{
            return false;
        }
    }

    /**
     * 获取时间天数,分割时间
     * @param $st
     * @param $et
     * @return array
     */
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