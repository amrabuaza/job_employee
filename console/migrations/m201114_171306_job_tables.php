<?php

use yii\db\Migration;

/**
 * Class m201114_171306_job_tables
 */
class m201114_171306_job_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%job}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'period' => $this->string()->notNull(),
            'status' => 'ENUM("pending","done","canceled") DEFAULT "pending"',
            'price' => $this->double()->notNull(),
            'owner_id' => $this->integer()->notNull(),
            'employee_id' => $this->integer()->null(),
            'address_id' => $this->integer()->notNull(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->createTable('{{%job_address}}', [
            'id' => $this->primaryKey(),
            'country' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'region' => $this->string()->notNull(),
            'street_name' => $this->string()->notNull(),
            'building_number_or_name' => $this->string()->notNull(),
            'floor_number' => $this->string()->notNull(),
            'apartment_number' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%job_offer}}', [
            'id' => $this->primaryKey(),
            'price' => $this->double()->notNull(),
            'job_id' => $this->integer()->notNull(),
            'employee_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_job_address_id', 'job', 'address_id', 'job_address', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_job_owner_id', 'job', 'owner_id', 'user', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_job_employee_id', 'job', 'employee_id', 'user', 'id', "CASCADE", "CASCADE");

        $this->addForeignKey('fk_job_offer_employee_id', 'job_offer', 'employee_id', 'user', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_job_offer_job_id', 'job_offer', 'job_id', 'job', 'id', "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201114_171306_job_tables cannot be reverted.\n";

        return false;
    }

}
