<?php

use yii\db\Migration;

/**
 * Class m180822_095819_add_group_relation_priv_table
 */
class m180822_095819_add_group_relation_priv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'group relation priv\'';
        }

        $this->createTable('{{%group_relation_priv}}', [
            'id'                    => $this->primaryKey()->comment('主键'),
            'group_id'              => $this->integer()->notNull()->defaultValue(0)->comment('群组id'),
            'prev_url'              => $this->string(200)->notNull()->defaultValue('')->comment('priv url'),
            'create_date'           => $this->dateTime()->notNull()->defaultValue('1000-00-01 00:00:01')->comment('创建时间'),
            'update_date'           => $this->dateTime()->notNull()->defaultValue('1000-00-01 00:00:01')->comment('更新时间'),
        ], $table_options);

        $this->createIndex(
            'group_id',
            '{{%group_relation_priv}}',
            'group_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_095819_add_group_relation_priv_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_095819_add_group_relation_priv_table cannot be reverted.\n";

        return false;
    }
    */
}
