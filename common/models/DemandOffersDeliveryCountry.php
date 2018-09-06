<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%demand_offers_delivery_country}}".
 *
 * @property int $id 主键
 * @property int $demand_offer_id 投放的offer id
 * @property int $country_id 投放的国家id, 0:代表所有国家
 * @property int $type 1:所有国家、2:需投放的国家、3:排除的国家
 * @property string $create_date 创建时间
 * @property string $update_date 更新时间
 */
class DemandOffersDeliveryCountry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%demand_offers_delivery_country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['demand_offer_id', 'country_id', 'type'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['demand_offer_id', 'country_id'], 'unique', 'targetAttribute' => ['demand_offer_id', 'country_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'demand_offer_id' => 'Demand Offer ID',
            'country_id' => 'Country ID',
            'type' => 'Type',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
        ];
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
    public static function getData($fields, $where = [], $group_by = '', $order_by = '', $limit = '', $is_return_sql = false)
    {
        $sql  = "SELECT " . implode(', ', $fields) . " FROM " . self::tableName();

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

    /**
     * 插入一条数据
     * @param $data
     * @param bool $return_sql
     * @return int|string
     */
    public static function addData($data, $return_sql =false)
    {
        $res = Yii::$app->db->createCommand()->insert(
            self::tableName(),
            $data
        );
        if ($return_sql) {
            return $res->getRawSql();
        }

        $res->execute();
        return $res ? Yii::$app->db->getLastInsertID() : 0;
    }

    /**
     * 多条数据插入
     * @param $data
     * @param bool $return_sql
     * @return int|string
     */
    public static function addAllData($data, $return_sql = false)
    {
        // 取得keys
        $keys   = !empty($data[0]) ? array_keys($data[0]) : [];
        if (empty($keys)) return false;

        $res = Yii::$app->db->createCommand()->batchInsert(
            self::tableName(),
            $keys,
            $data
        );

        if ($return_sql) return $res->getRawSql();

        $result = $res->execute();
        return $result;
    }

    /**
     * 修改数据
     * @param $set
     * @param $where
     * @param bool $return_sql
     * @return int|string
     */
    public static function updateData($set, $where, $return_sql = false)
    {
        $res = Yii::$app->db->createCommand()->update(
            self::tableName(),
            $set,
            $where
        );
        if ($return_sql) {
            return $res->getRawSql();
        }

        $result = $res->execute();
        return $result;
    }

    /**
     *  删除数据
     * @param $where
     * @return int
     */
    public static function deleteData($where)
    {
        return Yii::$app->db->createCommand()->delete(
            self::tableName(),
            $where
        )->execute();
    }
}
