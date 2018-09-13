<?php

namespace console\controllers;

use console\services\OfferReportingServices;
use Yii;
use yii\console\Controller;

class OfferReportingController extends Controller
{
    public function actionGetOfferData($st = '', $et = '', $offer_id = '', $user_id = '')
    {
        echo " ------------------ " . date('Y-m-d H:i:s') . " ------------------ \n";

        $start = microtime(true);

        $st = !empty($st) ? $st : date('Y-m-d');
        $et = !empty($et) ? $et : $st;

        $date = OfferReportingServices::getDateFromRange($st,$et);

        $offer_data = OfferReportingServices::getOfferId($offer_id,$user_id);

        if(!$offer_data){
            echo "没有offer数据\n";
        }else {

            $info = [];
            foreach ($date as $index => $val)
            {
                $params['date'] = $val;
                foreach ($offer_data as $k => $v)
                {
                    $params['offer_id'] = $v['offer_id'];
                    $res = OfferReportingServices::getData($params);

                    if (empty($res)) {
                        echo $v['offer_id'] . "没有拉取到数据\n";
                    } else {
                        foreach ($res as $key => $value)
                        {
                            $value['campaign_owner'] = $v['campaign_owner'];
                            array_push($info, $value);
                        }
                    }
                }
            }

            if($info) {
                OfferReportingServices::insertData($info);
            }

        }

        $end = microtime(true);

        echo "耗时:" . ($end - $start) . "\n";
        echo " ------------------ " . date('Y-m-d H:i:s') . " ------------------ \n";
    }
}