<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200804_123853_create_users_table extends Migration
{
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'        => $this->primaryKey(),
            'login'     => $this->string()->notNull()->unique(),
            'password'  => $this->string()->notNull(),
            'salt'      => $this->string(32)->notNull(),
            'status'    => $this->integer()->notNull()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
