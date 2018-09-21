<?php

use yii\db\Migration;

/**
 * Class m180917_034113_add_open_type_to_demand_offer_table
 */
class m180917_034113_add_open_type_to_demand_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%demand_offers}}',
            'open_type',
            $this->smallInteger(4)->notNull()->defaultValue(0)->comment('0：应用下载 1：外开落地页 2：内开落地页 ；默认是0')->after('comment')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180917_034113_add_open_type_to_demand_offer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180917_034113_add_open_type_to_demand_offer_table cannot be reverted.\n";

        return false;
    }
    */
}
