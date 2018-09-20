<?php

use yii\db\Migration;

/**
 * Class m180823_030249_add_offer_table
 */
class m180823_030249_add_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'group relation priv\'';
        }
        $this->createTable('{{%demand_offers}}', [
            'id' => $this->primaryKey()->comment('主键'),
            'channel' => $this->string(50)->notNull()->defaultValue('')->comment('offer所属渠道'),
            'campaign_owner' => $this->integer(11)->notNull()->defaultValue(0)->comment('offer所属广告商'),
            'title' => $this->string(100)->notNull()->defaultValue('')->comment('offer标题'),
            'pkg_name' => $this->string(150)->notNull()->defaultValue('')->comment('offer包名'),
            'desc' => $this->text()->comment('offer描述'),
            'payout' => $this->decimal(10,3)->notNull()->defaultValue('0.000')->comment('offer单价'),
            'price_way' => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('付款方式:1:CPI 2:CPC 3:CPA 4:CPM'),
            'tracking_url' => $this->string(500)->notNull()->defaultValue('')->comment('offer跳转url'),
            'final_url' => $this->string(500)->notNull()->defaultValue('')->comment('offer最终的页面'),
            'category_id' => $this->integer()->notNull()->defaultValue(0)->comment('offer所属分类id'),
            'daily_cap' => $this->integer(11)->notNull()->defaultValue(-1)->comment('每日上限:-1:无上限'),
            'total_cap' => $this->integer(11)->notNull()->defaultValue(-1)->comment('总上限:-1:无上限'),
            'platform' => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('offer投放平台, 1:ANDROID、2:IOS'),
            'device_target' => $this->string(24)->notNull()->defaultValue('')->comment('设备定向:iOS平台可选1:phone;2:ipad;3:unlimited; Android平台可选1:phone;2:tablet;3:unlimited'),
            'min_os_version' => $this->string(25)->notNull()->defaultValue('')->comment('最小版本号'),
            'sponsor' => $this->string(80)->notNull()->defaultValue('')->comment('广告主'),
            'att_pro' => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('attribution provider(默认值为：0) 1:Adjust  2:AppsFlyer  3:Talking Dat  4:热云  5:友盟'),
            'network_environment' => $this->smallInteger(2)->notNull()->defaultValue(3)->comment('网络环境 1:wifi 2:unwifi 3 wifi & unwifi'),
            'delivery_status' => $this->smallInteger(4)->notNull()->defaultValue(2)->comment('投放时间开关。1:open; 2:close'),
            'delivery_start_day' => $this->date()->notNull()->defaultValue('1000-00-01')->comment('投放开始时间'),
            'delivery_end_day' => $this->date()->notNull()->defaultValue('1000-00-01')->comment('投放结束时间'),
            'delivery_week' => $this->string(40)->notNull()->defaultValue('')->comment('投放周'),
            'delivery_hour' => $this->string(100)->notNull()->defaultValue('')->comment('投放小时'),
            'url_schema' => $this->string(2000)->notNull()->defaultValue('')->comment('图形url'),
            'specific_device' => $this->text()->comment('设备机型'),
            'status' => $this->smallInteger(4)->notNull()->defaultValue(1)->comment('offer状态 1：正在投放的offer 2：offer关闭'),
            'comment' => $this->text()->comment('创建者对广告的信息记录'),
            'create_date' => $this->dateTime()->notNull()->defaultValue('0000-00-00 00:00:00')->comment('offer创建时间'),
            'update_date' => $this->dateTime()->notNull()->defaultValue('0000-00-00 00:00:00')->comment('offer更新时间'),
        ], $table_options);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_030249_add_offer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_030249_add_offer_table cannot be reverted.\n";

        return false;
    }
    */
}
