<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%offer_reporting}}".
 *
 * @property string $date 日期
 * @property string $country 国家
 * @property string $offer_id offer_id
 * @property int $click 点击数
 * @property int $conversion 转化数
 * @property string $payout 支出
 */
class OfferReporting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%offer_reporting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['country', 'offer_id'], 'required'],
            [['click', 'conversion'], 'integer'],
            [['payout'], 'number'],
            [['country'], 'string', 'max' => 50],
            [['offer_id'], 'string', 'max' => 100],
            [['offer_id', 'country'], 'unique', 'targetAttribute' => ['offer_id', 'country']],
            [['country', 'offer_id'], 'unique', 'targetAttribute' => ['country', 'offer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'country' => 'Country',
            'offer_id' => 'Offer ID',
            'click' => 'Click',
            'conversion' => 'Conversion',
            'payout' => 'Payout',
        ];
    }

    /**
     * 数据插入更新
     * @param $res
     * @return bool|int
     */
    public static function batchInsertAndUpdate($res)
    {
        // 取得keys
        $keys   = !empty($res[0]) ? array_keys($res[0]) : [];
        if (empty($keys)) return false;

        // 取得sql keys
        $str_sql_keys   = "(`" . implode("`,`", $keys) . "`)";

        // 取得sql values
        $sql_values = [];
        foreach ($res as $key => $value)
        {
            $sql_values[$key]   = "('" . implode("','", $value) . "')";
        }
        $str_sql_values = implode(", ", $sql_values);

        // 取得sql update values
        $update_sql_values  = [];
        foreach ($keys as $i => $v)
        {
            $update_sql_values[$i] = $v . " = VALUES(" . $v . ")";
        }
        $str_update_sql_values  = implode(", ", $update_sql_values);

        // 组合sql
        $sql = "INSERT INTO " . self::tableName() . $str_sql_keys .
            " VALUES " . $str_sql_values .
            " ON DUPLICATE KEY UPDATE " . $str_update_sql_values;

        return Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * 查询数据
     * @param $fields
     * @param $where
     * @param string $group_by
     * @param string $order_by
     * @param string $limit
     * @param bool $is_return_sql
     * @return array|string
     */
    public static function getData($fields, $where = [], $group_by = '', $order_by = '', $limit = null, $is_return_sql = false)
    {
        $sql  = "SELECT " . implode(', ', $fields) . " FROM "
            . self::tableName();

        if (!empty($where)) {
           $sql .= " WHERE " . implode(' AND ', $where);
        }

        if ( !empty($group_by) ) {
            $sql    .= " GROUP BY " . $group_by;
        }

        if ( !empty($order_by) ) {
            $sql    .= " ORDER BY " . $order_by;
        }

        if ( !empty($limit) ) {
            $sql    .= " LIMIT " . $limit;
        }

        if ($is_return_sql) return $sql;
        return Yii::$app->db->createCommand($sql)->queryAll();
    }


    public static function getDataBySql($sql)
    {
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

}