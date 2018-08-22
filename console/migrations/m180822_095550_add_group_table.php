<?php

use yii\db\Migration;

/**
 * Class m180822_095550_add_group_table
 */
class m180822_095550_add_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'user group\'';
        }

        $this->createTable('{{%user_group}}', [
            'id'                    => $this->primaryKey()->comment('主键'),
            'group_name'            => $this->string(100)->notNull()->defaultValue('')->comment('群组名称'),
            'status'                => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('群组状态2:disable、1:enable'),
            'create_date'           => $this->dateTime()->notNull()->defaultValue('1000-00-01 00:00:01')->comment('创建时间'),
            'update_date'           => $this->dateTime()->notNull()->defaultValue('1000-00-01 00:00:01')->comment('更新时间'),
        ], $table_options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_095550_add_group_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_095550_add_group_table cannot be reverted.\n";

        return false;
    }
    */
}
