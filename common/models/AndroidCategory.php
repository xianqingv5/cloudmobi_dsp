<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%android_category}}".
 *
 * @property int $id 主键
 * @property string $en_name 英文分类名
 * @property string $zh_cn 中文分类名
 * @property string $ja 日文分类名
 * @property int $parent_id 父id
 * @property int $dimension 维度
 */
class AndroidCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%android_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'dimension'], 'integer'],
            [['en_name', 'zh_cn', 'ja'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'en_name' => 'En Name',
            'zh_cn' => 'Zh Cn',
            'ja' => 'Ja',
            'parent_id' => 'Parent ID',
            'dimension' => 'Dimension',
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
    public static function getData($fields, $where, $group_by = '', $order_by = '', $limit = '', $is_return_sql = false)
    {
        $sql  = "SELECT " . implode(', ', $fields) . " FROM "
            . self::tableName() . " WHERE " . implode(' AND ', $where);

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
     * 插入数据
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
