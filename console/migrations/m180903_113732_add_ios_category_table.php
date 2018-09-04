<?php

use yii\db\Migration;

/**
 * Class m180903_113732_add_ios_category_table
 */
class m180903_113732_add_ios_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'ios category\'';
        }

        $this->createTable('{{%ios_category}}', [
            'id' => $this->primaryKey()->comment('主键'),
            'en_name' => $this->string(50)->notNull()->defaultValue('')->comment('英文分类名'),
            'zh_cn' => $this->string(50)->notNull()->defaultValue('')->comment('中文分类名'),
            'ja' => $this->string(50)->notNull()->defaultValue('')->comment('日文分类名'),
            'parent_id' => $this->integer(11)->notNull()->defaultValue(0)->comment('父id'),
            'dimension' => $this->smallInteger(4)->notNull()->defaultValue(1)->comment('维度'),
        ], $table_options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180903_113732_add_ios_category_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_113732_add_ios_category_table cannot be reverted.\n";

        return false;
    }
    */
}
