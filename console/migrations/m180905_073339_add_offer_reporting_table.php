<?php

use yii\db\Migration;

/**
 * Class m180905_073339_add_offer_reporting_table
 */
class m180905_073339_add_offer_reporting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'offer reporting\'';
        }

        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey()->comment('主键'),
            'full_name' => $this->string(100)->notNull()->defaultValue('')->comment('英文名'),
            'short_name' => $this->string(50)->notNull()->defaultValue('')->comment('英文缩写'),
            'zh_cn' => $this->string(50)->notNull()->defaultValue('')->comment('中文名'),
            'ja' => $this->string(50)->notNull()->defaultValue('')->comment('日文名'),
        ], $table_options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180905_073339_add_offer_reporting_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_073339_add_offer_reporting_table cannot be reverted.\n";

        return false;
    }
    */
}
