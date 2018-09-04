<?php
namespace backend\services;

use Yii;
use common\models\Country;

class CountryService extends BaseService
{
    public static function getCountryAllData($fields=['*'], $where=[])
    {
        $res = Country::getData($fields, $where);
        return $res;
    }
}