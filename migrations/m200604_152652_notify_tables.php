<?php

use yii\db\Migration;

/**
 * Class m200604_152652_notify_tables
 */
class m200604_152652_notify_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fin_boards}}', [
            'id'   => $this->bigPrimaryKey()->notNull()->,
            'mobile_phone' => $this->string(255)->notNull(),
            'email'  => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200604_152652_notify_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200604_152652_notify_tables cannot be reverted.\n";

        return false;
    }
    */
}
