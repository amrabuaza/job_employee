<?php

use yii\db\Migration;

/**
 * Class m201114_170841_user_tables
 */
class m201114_170841_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_address}}', [
            'id' => $this->primaryKey(),
            'country' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk_user_address', 'user', 'address_id', 'user_address', 'id', "CASCADE", "CASCADE");

        $this->createTable('{{%interest}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%user_interest_in}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'interest_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_user_interest_in_user_id', 'user_interest_in', 'user_id', 'user', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_user_interest_in_interest_id', 'user_interest_in', 'interest_id', 'interest', 'id', "CASCADE", "CASCADE");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201114_170841_user_tables cannot be reverted.\n";

        return false;
    }

}
