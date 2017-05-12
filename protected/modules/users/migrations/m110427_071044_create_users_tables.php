<?php

class m110427_071044_create_users_tables extends CDbMigration
{
    public function up() {
        $this->createTable('{{user}}', array(
            'id' => 'pk',

            'email' => 'string not null',

            'password' => 'string',
            'salt' => 'string',

            'role' => 'string',

            'create_time' => 'integer',
            'update_time' => 'integer',

            // Общие поля и для клиента и для дилера
            'name' => 'string',


        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{authservice}}', array(
            'id' => 'VARCHAR(255) PRIMARY KEY',
            'servicename' => 'VARCHAR(255)',
            'user_id' => 'integer not null',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->insert('{{user}}', array(
            'email' => '3@3colors.ru',
            'password' => sha1('12345'),
            'role' => 'root',
            'create_time' => time(),
            'update_time' => time(),
            'name' => 'Super User',
        ));
    }

    public function down() {
        $this->dropTable('{{authservice}}');
        $this->dropTable('{{user}}');
    }
}

