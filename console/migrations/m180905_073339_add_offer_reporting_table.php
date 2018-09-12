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

        $this->createTable('{{%offer_reporting}}', [
            'date' => $this->date()->notNull()->defaultValue('1000-01-01')->comment('日期'),
            'offer_id' => $this->string(30)->notNull()->defaultValue('')->comment('offer_id'),
            'country' => $this->integer(11)->notNull()->defaultValue(0)->comment('国家'),
            'platform' => $this->smallInteger(2)->notNull()->defaultValue(0)->comment('平台:1:android,2:IOS,3:unknown'),
            'click' => $this->integer(11)->notNull()->defaultValue(0)->comment('点击数'),
            'conversion' => $this->integer(11)->notNull()->defaultValue(0)->comment('转化数'),
            'payout' => $this->decimal(11,3)->notNull()->defaultValue(0)->comment('支出'),
            'create_date' => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
        ], $table_options);

        $this->createIndex('reporting', '{{%offer_reporting}}', ['date','offer_id','country','platform'], true);
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
