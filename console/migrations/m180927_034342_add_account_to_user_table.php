<?php

use yii\db\Migration;

/**
 * Class m180927_034342_add_account_to_user_table
 */
class m180927_034342_add_account_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%user}}',
            'short_name',
            $this->string(10)->notNull()->after('username')->comment('简称')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180927_034342_add_account_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180927_034342_add_account_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
