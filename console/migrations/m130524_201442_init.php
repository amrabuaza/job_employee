<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'first_name' => $this->string()->unique(),
            'last_name' => $this->string()->unique(),
            'phone_number' => $this->string()->unique(),
            'gender' => 'ENUM("male","female") DEFAULT NULL',
            'user_type' => 'ENUM("admin","job_owner","employee") DEFAULT "employee"',
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'device_token' => $this->string()->null()->unique(),
            'access_token' => $this->string()->null()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'is_verified' => $this->smallInteger()->notNull()->defaultValue(0),
            'address_id' => $this->integer()->null(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
