<?php
/**
 * Created by PhpStorm.
 * User: yeahmobi
 * Date: 18/1/5
 * Time: 14:48
 */

namespace backend\libs;

use Yii;

class RedisSetLibrary
{
    /**
     * 插入redis 有序集合
     *
     * @param $message
     * @param $key
     * @return bool
     */
    public static function insertZData( $message, $key )
    {
        if ( empty( $key ) )
        {
            return false;
        }

        if ( is_array( $message ) )
        {
            foreach ( $message as $value )
            {
                $res = Yii::$app->redis->zadd( $key, microtime(true), json_encode( $value ) ) ;

                if ( empty( $res ) )
                {
                    return false;
                }
            }

            return true;
        }

        $res = Yii::$app->redis->zadd( $key, microtime(true) , $message );

        return !empty( $res ) ? true : false;
    }

    /**
     * 获取redis 有序集合内容
     *
     * @param $key
     * @param int $start
     * @param int $end
     * @return array|bool
     */
    public static function getZRangeData( $key, $start = 0, $end = -1 )
    {
        if ( empty( $key ) )
        {
            return false;
        }

        $res =  Yii::$app->redis->zrange( $key, $start, $end );

        return !empty($res) ? $res : [];
    }

    /**
     * 获取redis 有序集合内容存储值的数量
     *
     * @param $key
     * @param int $start
     * @param int $end
     * @return array|bool
     */
    public static function getZCount( $key, $start = 0, $end = -1 )
    {
        if ( empty( $key ) )
        {
            return false;
        }

        $res =  Yii::$app->redis->zcount( $key, $start, $end );

        return !empty($res) ? $res : 0;
    }

    /**
     * 获取部分逆向排序redis 有序集合内容
     *
     * @param $key
     * @param $start
     * @param $end
     * @return array|bool
     */
    public static function getZRevRangeData( $key, $start, $end )
    {
        if ( empty( $key ) )
        {
            return false;
        }

        $res =  Yii::$app->redis->zrevrange( $key, $start, $end );

        return !empty($res) ? $res : [];
    }

    /**
     * 移除全部redis 有序集合内容
     *
     * @param $key
     * @return bool
     */
    public static function removeZData( $key )
    {
        if ( empty( $key ) )
        {
            return false;
        }

        $res = Yii::$app->redis->zremrangebyrank( $key, 0, -1 );

        return !empty($res) ? $res : 0;
    }

}