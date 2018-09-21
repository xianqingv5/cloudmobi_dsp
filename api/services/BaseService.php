<?php
namespace api\services;

use Yii;
use yii\log\Logger;
use common\models\Country;

class BaseService
{
    // 返回结果数组
    public static $res = ['status'=>200, 'info'=>'', 'data'=>[]];

    // token
    public static $token = '3CdfhPDRphp3h5tc';

    public static $code = [
        'success'           => 200,
        'forbidden'         => 403,
        'request_error'     => 400,
        'server_error'      => 500,
    ];

    /**
     * token 验证
     * @return bool
     */
    public static function checkToken()
    {
        $token = Yii::$app->request->get('token', '');
        if ($token !== self::$token) {
            self::$res['status'] = self::$code['forbidden'];
            self::$res['info'] = 'Token error';
            return false;
        }

        return true;
    }

    /**
     * 获取国家信息
     * @param array $fields
     * @param array $where
     * @return array|string
     */
    public static function getCountryData($fields = ['*'], $where = [])
    {
        $res = Country::getData($fields, $where);
        return $res;
    }


    /**
     * 错误写入日志
     * @param $message
     */
    public static function logs($message) {
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $message =  "$controller/$action : " . $message . "\n";
        Yii::getLogger()->log($message, Logger::LEVEL_ERROR);
    }
}