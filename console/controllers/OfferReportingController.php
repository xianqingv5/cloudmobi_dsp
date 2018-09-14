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
$offer_data = ['mn_offline594','mn_offline601','ym_9186915','ym_267920','ym_12584941','ym_12848028','ym_8264416','ym_12481459','wdg2_3872','wdg2_4008','wdg2_55721','wdg2_457702','wdg2_273280','wdg2_4121','pst_16442109','pst_15648198','pst_12345055','pst_16491137','pst_18105963','pst_18612948','pst_18444599','pst_11501622','wby3_51461836','wby3_51461849','wby3_38711525','wby3_47586943','wby3_38588551','wby3_35589396','wby3_51461848','wby3_44127074'];
        if(!$offer_data){
            echo "没有offer数据\n";
        }else {

            $info = [];
            foreach ($date as $index => $val)
            {
                $params['date'] = $val;
                foreach ($offer_data as $k => $v)
                {
                    $params['offer_id'] = $v;
                    $res = OfferReportingServices::getData($params);

                    if (empty($res)) {
                        echo $v . "--$val--没有拉取到数据\n";
                    } else {
                        echo $v . "--$val--拉取到数据\n";
                        foreach ($res as $key => $value)
                        {
                            $value['campaign_owner'] = 1;
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