<?php

use yii\db\Migration;

/**
 * Class m180822_094313_add_user_table
 */
class m180822_094313_add_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(100)->notNull()->unique()->comment('email'),
            'username' => $this->string()->notNull()->defaultValue('')->comment('用户名'),
            'salt' => $this->char(4)->notNull()->defaultValue('')->comment('随机数'),
            'password' => $this->char(32)->notNull()->defaultValue('')->comment('密码'),
            'group_id' => $this->integer()->notNull()->defaultValue(0)->comment('所属群组'),
            'pid' => $this->integer(11)->notNull()->defaultValue(0)->comment('父id'),
            'status'  => $this->smallInteger()->notNull()->defaultValue(1)->comment('是否停用此用户2:disable、1:enable'),
            'comment' => $this->text()->comment('描述'),
            'create_date' => $this->dateTime()->notNull()->defaultValue('1000-00-01 00:00:01')->comment('创建时间'),
            'update_date' => $this->dateTime()->notNull()->defaultValue('1000-00-01 00:00:01')->comment('更新时间'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_094313_add_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_094313_add_user_table cannot be reverted.\n";

        return false;
    }
    */
}
