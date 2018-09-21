<?php

use yii\db\Migration;

/**
 * Class m180823_094201_add_third_party_monitoring_table
 */
class m180823_094201_add_third_party_monitoring_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'third party monitoring\'';
        }

        $this->createTable('{{%third_party_monitoring}}', [
            'id'                => $this->primaryKey()->comment('主键'),
            'tpm' => $this->string(50)->notNull()->defaultValue('')->comment('第三方监测'),
            'channel' => $this->string(20)->notNull()->defaultValue('')->comment('对应channel'),
            'create_date'       => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
            'update_date'       => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('更新时间'),
        ], $table_options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_094201_add_third_party_monitoring_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_094201_add_third_party_monitoring_table cannot be reverted.\n";

        return false;
    }
    */
}
