<?php

use yii\db\Migration;

/**
 * Class m180906_072818_add_field_to_demand_offer_table
 */
class m180906_072818_add_field_to_demand_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%demand_offers}}',
            'comment',
            $this->text()->comment('创建者对广告的信息记录')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_072818_add_field_to_demand_offer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_072818_add_field_to_demand_offer_table cannot be reverted.\n";

        return false;
    }
    */
}
