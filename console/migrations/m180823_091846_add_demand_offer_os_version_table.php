<?php

use yii\db\Migration;

/**
 * Class m180823_091846_add_demand_offer_os_version_table
 */
class m180823_091846_add_demand_offer_os_version_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'demand offers os version\'';
        }

        $this->createTable('{{%demand_offers_os_version}}', [
            'id'                => $this->primaryKey()->comment('主键'),
            'demand_offer_id'   => $this->integer()->notNull()->defaultValue(0)->comment('投放的offer id'),
            'platform'          => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('offer投放平台, 1:ANDROID、2:IOS'),
            'os_version'        => $this->string(50)->notNull()->defaultValue('')->comment('offer投放的操作系统版本'),
            'create_date'       => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
            'update_date'       => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('更新时间'),
        ], $table_options);

        $this->createIndex(
            'demand_offer_id',
            '{{%demand_offers_os_version}}',
            'demand_offer_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_091846_add_demand_offer_os_version_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_091846_add_demand_offer_os_version_table cannot be reverted.\n";

        return false;
    }
    */
}
