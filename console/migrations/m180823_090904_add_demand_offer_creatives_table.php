<?php

use yii\db\Migration;

/**
 * Class m180823_090904_add_demand_offer_creatives_table
 */
class m180823_090904_add_demand_offer_creatives_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT \'demand offers creatives\'';
        }

        $this->createTable('{{%demand_offers_creatives}}', [
            'id'                            => $this->primaryKey()->comment('主键'),
            'demand_offer_id'               => $this->integer()->notNull()->defaultValue(0)->comment('投放的offer id'),
            'url'                           => $this->string(400)->notNull()->defaultValue('')->comment('素材url'),
            'mime_type'                     => $this->string(100)->notNull()->defaultValue('')->comment('素材mime type'),
            'width'                         => $this->smallInteger()->notNull()->defaultValue(0)->comment('素材宽度'),
            'height'                        => $this->smallInteger()->notNull()->defaultValue(0)->comment('素材高度'),
            'size'                          => $this->integer()->notNull()->defaultValue(0)->comment('素材大小'),
            'type'                          => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('1:icon; 2:image; 3:video'),
            'status'                        => $this->smallInteger(4)->notNull()->defaultValue(1)->comment('1:enable; 2:disable;'),
            'create_date'                   => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('创建时间'),
            'update_date'                   => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:01')->comment('更新时间'),
        ], $table_options);

        $this->createIndex(
            'demand_offer_id',
            '{{%demand_offers_creatives}}',
            'demand_offer_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_090904_add_demand_offer_creatives_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_090904_add_demand_offer_creatives_table cannot be reverted.\n";

        return false;
    }
    */
}
