<?php

use yii\db\Migration;

/**
 * Class m180828_062652_add_user_relation_user_table
 */
class m180828_062652_add_user_relation_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'用户关联表\'';
        }

        $this->createTable('{{%user_relation_user}}', [
            'id'                    => $this->primaryKey()->comment('主键'),
            'user_id'               => $this->integer()->notNull()->defaultValue(0)->comment('User ID'),
            'relation_user_id'      => $this->integer()->notNull()->defaultValue(0)->comment('关联用户ID'),
            'type'                  => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('类型,1:代理广告主与广告主'),
            'create_date'           => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
            'update_date'           => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('更新时间'),
        ], $table_options);

        // 创建索引
        $this->createIndex(
            'urt',
            "{{%user_relation_user}}",
            ['user_id', 'relation_user_id', 'type'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_062652_add_user_relation_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_062652_add_user_relation_user_table cannot be reverted.\n";

        return false;
    }
    */
}
