<?php

use yii\db\Migration;

/**
 * Class m180823_093619_add_advertiser_table
 */
class m180823_093619_add_advertiser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'advertiser\'';
        }

        $this->createTable('{{%advertiser}}', [
            'id'  => $this->primaryKey()->comment('主键'),
            'ads' => $this->string(50)->notNull()->defaultValue('')->comment('广告主'),
        ], $table_options);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_093619_add_advertiser_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_093619_add_advertiser_table cannot be reverted.\n";

        return false;
    }
    */
}
