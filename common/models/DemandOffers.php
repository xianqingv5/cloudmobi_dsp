<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%demand_offers}}".
 *
 * @property int $id 主键
 * @property string $channel offer所属渠道
 * @property int $campaign_owner offer所属广告商
 * @property string $title offer标题
 * @property string $pkg_name offer包名
 * @property string $desc offer描述
 * @property int $offer_open_type 0：应用下载 1：外开落地页 2：内开落地页 ；默认是0
 * @property string $payout offer单价
 * @property int $price_way 付款方式:1:CPI 2:CPC 3:CPA 4:CPM
 * @property string $tracking_url offer跳转url
 * @property string $click_url json格式: click跳转url
 * @property string $final_url offer最终的页面
 * @property string $impression_url json格式: impression跳转url
 * @property int $category_id offer所属分类id
 * @property int $daily_cap 每日上限:-1:无上限
 * @property int $Total_cap 总上限:-1:无上限
 * @property string $tak 淘口令
 * @property string $tbk_remarks 淘口令备注
 * @property int $tbk_t 写入时间,1：不写入，2：广告被展示时，3：广告被点击时
 * @property int $platform offer投放平台, 1:ANDROID、2:IOS
 * @property int $device_target 设备定向:iOS平台可选1:phone;2:ipad;3:unlimited; Android平台可选1:phone;2:tablet;3:unlimited
 * @property string $min_os_version 最小版本号
 * @property int $pacing offer pacing
 * @property string $sponsor 广告主
 * @property int $att_pro attribution provider(默认值为：0) 1:Adjust  2:AppsFlyer  3:Talking Dat  4:热云  5:友盟
 * @property string $operator 广告主
 * @property int $network_environment 网络环境 1:wifi 2:unwifi 3 wifi & unwifi
 * @property int $delivery_status 投放时间开关。1:open; 2:close
 * @property string $delivery_start_day 投放开始时间
 * @property string $delivery_end_day 投放结束时间
 * @property string $delivery_week 投放周
 * @property string $delivery_hour 投放小时
 * @property int $delivery_city_status 投放城市状态。1:open; 2:close
 * @property string $delivery_city 投放城市json
 * @property string $url_schema 图形url
 * @property string $specific_devide 设备机型
 * @property int $status offer状态 1：正在投放的offer 2：offer关闭
 * @property string $create_date offer创建时间
 * @property string $update_date offer更新时间
 */
class DemandOffers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%demand_offers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campaign_owner', 'offer_open_type', 'price_way', 'category_id', 'daily_cap', 'Total_cap', 'tbk_t', 'platform', 'device_target', 'pacing', 'att_pro', 'network_environment', 'delivery_status', 'delivery_city_status', 'status'], 'integer'],
            [['desc', 'tbk_remarks', 'operator', 'delivery_city', 'specific_devide'], 'string'],
            [['payout'], 'number'],
            [['device_target'], 'required'],
            [['delivery_start_day', 'delivery_end_day', 'create_date', 'update_date'], 'safe'],
            [['channel'], 'string', 'max' => 50],
            [['title', 'delivery_hour'], 'string', 'max' => 100],
            [['pkg_name'], 'string', 'max' => 150],
            [['tracking_url', 'final_url'], 'string', 'max' => 500],
            [['click_url'], 'string', 'max' => 1500],
            [['impression_url', 'url_schema'], 'string', 'max' => 2000],
            [['tak'], 'string', 'max' => 255],
            [['min_os_version'], 'string', 'max' => 25],
            [['sponsor'], 'string', 'max' => 80],
            [['delivery_week'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'campaign_owner' => 'Campaign Owner',
            'title' => 'Title',
            'pkg_name' => 'Pkg Name',
            'desc' => 'Desc',
            'offer_open_type' => 'Offer Open Type',
            'payout' => 'Payout',
            'price_way' => 'Price Way',
            'tracking_url' => 'Tracking Url',
            'click_url' => 'Click Url',
            'final_url' => 'Final Url',
            'impression_url' => 'Impression Url',
            'category_id' => 'Category ID',
            'daily_cap' => 'Daily Cap',
            'Total_cap' => 'Total Cap',
            'tak' => 'Tak',
            'tbk_remarks' => 'Tbk Remarks',
            'tbk_t' => 'Tbk T',
            'platform' => 'Platform',
            'device_target' => 'Device Target',
            'min_os_version' => 'Min Os Version',
            'pacing' => 'Pacing',
            'sponsor' => 'Sponsor',
            'att_pro' => 'Att Pro',
            'operator' => 'Operator',
            'network_environment' => 'Network Environment',
            'delivery_status' => 'Delivery Status',
            'delivery_start_day' => 'Delivery Start Day',
            'delivery_end_day' => 'Delivery End Day',
            'delivery_week' => 'Delivery Week',
            'delivery_hour' => 'Delivery Hour',
            'delivery_city_status' => 'Delivery City Status',
            'delivery_city' => 'Delivery City',
            'url_schema' => 'Url Schema',
            'specific_devide' => 'Specific Devide',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * 查询数据
     * @param $fields
     * @param array $where
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
