<?php

use yii\db\Migration;

/**
 * Class m180823_090235_add_demand_offer_conversion_table
 */
class m180823_090235_add_demand_offer_conversion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'demand offers conversion\'';
        }

        $this->createTable('{{%demand_offers_conversion}}', [
            'id'                            => $this->primaryKey()->comment('主键'),
            'demand_offer_id'               => $this->integer()->notNull()->defaultValue(0)->comment('投放的offer id'),
            'day'                           => $this->date()->notNull()->defaultValue('1000-01-01')->comment('生效时间'),
            'pay_out'                       => $this->integer()->notNull()->defaultValue(0)->comment('Pay out'),
            'price'                         => $this->integer()->notNull()->defaultValue(0)->comment('Price'),
            'conversion'                    => $this->integer()->notNull()->defaultValue(0)->comment('Conversion'),
            'create_date'                   => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
            'update_date'                   => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('更新时间'),
        ], $table_options);

        $this->createIndex(
            'demand_offer_id',
            '{{%demand_offers_conversion}}',
            'demand_offer_id'
        );

        // 创建索引
        $this->createIndex(
            'dd',
            "{{%demand_offers_conversion}}",
            ['demand_offer_id', 'day'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_090235_add_demand_offer_conversion_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_090235_add_demand_offer_conversion_table cannot be reverted.\n";

        return false;
    }
    */
}
