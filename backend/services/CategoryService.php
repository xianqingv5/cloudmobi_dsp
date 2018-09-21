<?php
namespace backend\services;

use Yii;
use common\models\AndroidCategory;
use common\models\IosCategory;

class CategoryService extends BaseService
{
    /**
     * 获取android & ios 广告类型
     * @param int $type 0:android & ios  1:android  2:ios
     * @param array $fields
     * @param array $where
     * @return array|string
     */
    public static function getCategoryData($type = 0, $fields=['*'], $where=['1=1'])
    {
        $res = [];
        switch ($type) {
            case 0:// android & ios
                $res['android'] = self::getAndroidCategory($fields, $where);
                $res['ios'] = self::getIosCategory($fields, $where);
                break;
            case 1:// android
                $res = self::getAndroidCategory($fields, $where);
                break;
            case 2:// ios
                $res = self::getIosCategory($fields, $where);
                break;
            default :
                break;
        }

        return $res;
    }

    /**
     * android category
     * @param $fields
     * @param $where
     * @return array|string
     */
    private static function getAndroidCategory($fields, $where)
    {
        $res = AndroidCategory::getData($fields, $where);
        return $res;
    }

    /**
     * ios category
     * @param $fields
     * @param $where
     * @return array|string
     */
    private static function getIosCategory($fields, $where)
    {
        $res = IosCategory::getData($fields, $where);
        return $res;
    }
}