<?php

use yii\db\Migration;

/**
 * Class m180927_032801_add_delivery_price_to_demand_offer_table
 */
class m180927_032801_add_delivery_price_to_demand_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%demand_offers}}',
            'offer_id',
            $this->string(30)->notNull()->after('id')->comment('offer id')
        );

        $this->addColumn(
            '{{%demand_offers}}',
            'delivery_price',
            $this->decimal(10,3)->notNull()->defaultValue('0.000')->after('payout')->comment('offer投放单价')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180927_032801_add_delivery_price_to_demand_offer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180927_032801_add_delivery_price_to_demand_offer_table cannot be reverted.\n";

        return false;
    }
    */
}
