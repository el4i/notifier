<?php

use yii\db\Migration;

/**
 * Class m200604_175135_notifier_tables
 */
class m200604_175135_notifier_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customers}}', [
            'id'   => 'INT(11) NOT NULL AUTO_INCREMENT',
            'mobile_phone' => $this->string(14),
            'email'  => $this->string(68),
            'PRIMARY KEY (`id`)',
        ]);

        $this->createTable('{{%purchases}}', [
            'buy_id'   => 'INT(11) NOT NULL AUTO_INCREMENT',
            'product' => $this->string(255),
            'price'  => $this->float(),
            'sms_sent' =>"VARCHAR(1) NOT NULL DEFAULT 'N'",
            'email_sent' =>"VARCHAR(1) NOT NULL DEFAULT 'N'",
            'customer_id' =>'INT(11) NOT NULL',
            'PRIMARY KEY (`buy_id`)',
        ]);
        $this->createTable('{{%errors}}', [
            'id'   => 'INT(11) NOT NULL AUTO_INCREMENT',
            'purchase_id' => 'INT(11) NOT NULL',
            'customer_id'  => 'INT(11) NOT NULL',
            'error_desc'  => $this->string(255),
            'error_date'  => $this->dateTime(),
            'PRIMARY KEY (`id`)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200604_175135_notifier_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200604_175135_notifier_tables cannot be reverted.\n";

        return false;
    }
    */
}
