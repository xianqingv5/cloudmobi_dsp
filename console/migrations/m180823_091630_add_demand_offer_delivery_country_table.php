<?php

use yii\db\Migration;

/**
 * Class m180823_091630_add_demand_offer_delivery_country_table
 */
class m180823_091630_add_demand_offer_delivery_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'demand offers delivery country\'';
        }

        $this->createTable('{{%demand_offers_delivery_country}}', [
            'id'                            => $this->primaryKey()->comment('主键'),
            'demand_offer_id'               => $this->integer()->notNull()->defaultValue(0)->comment('投放的offer id'),
            'country_id'                    => $this->integer()->notNull()->defaultValue(0)->comment('投放的国家id, 0:代表所有国家'),
            'type'                          => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('1:所有国家、2:需投放的国家、3:排除的国家'),
            'create_date'                   => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
            'update_date'                   => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('更新时间'),
        ], $table_options);

        $this->createIndex(
            'dc',
            '{{%demand_offers_delivery_country}}',
            ['demand_offer_id', 'country_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_091630_add_demand_offer_delivery_country_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_091630_add_demand_offer_delivery_country_table cannot be reverted.\n";

        return false;
    }
    */
}
