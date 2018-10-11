<?php

use yii\db\Migration;

/**
 * Class m181011_054946_add_impression_url_to_demand_offer_table
 */
class m181011_054946_add_impression_url_to_demand_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%demand_offers}}',
            'impression_url',
            $this->string(2000)->notNull()->defaultValue('')->comment('json格式:impression跳转url')->after('final_url')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181011_054946_add_impression_url_to_demand_offer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181011_054946_add_impression_url_to_demand_offer_table cannot be reverted.\n";

        return false;
    }
    */
}
