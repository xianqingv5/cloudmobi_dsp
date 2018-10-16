<?php

namespace console\controllers;

use console\services\OfferReportingServices;
use Yii;
use yii\console\Controller;

class OfferReportingController extends Controller
{
    public function actionGetOfferData($st = '', $et = '', $offer_id = '', $user_id = '')
    {
        $start = microtime(true);
        // 获取拉取数据时间
        $st = !empty($st) ? $st : date('Y-m-d', strtotime('-1 day'));
        $et = !empty($et) ? $et : $st;
        // 判断拉取数据天数
        $date = OfferReportingServices::getDateFromRange($st,$et);

        $offer_data = OfferReportingServices::getOfferId($offer_id,$user_id);
        if(!$offer_data){
            echo "没有offer数据\n";
        }else {
            echo " ------------------ 正在拉取 ------------------ \n";
            foreach ($date as $index => $val)
            {
                $info = [];
                $params['date'] = $val;
                foreach ($offer_data as $k => $v)
                {
//                    $params['offer_id'] = $v;
                    $params['offer_id'] = $v['offer_id'];
                    $res = OfferReportingServices::getData($params);

                    if (empty($res)) {
//                        echo $v . "--$val--没有拉取到数据\n";
                        echo $v['offer_id'] . "--$val--没有拉取到数据\n";
                        echo " ------------------ 正在拉取 ------------------ \n";
                    } else {
                        foreach ($res as $key => $value)
                        {
                            $value['campaign_owner'] = $v['campaign_owner'];
                            array_push($info, $value);
                        }
                    }
                }
                if($info) {
                    OfferReportingServices::insertData($info);
                }
            }
        }

        $end = microtime(true);

        echo "耗时:" . ($end - $start) . "\n";
    }
}