<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'created_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'updated_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'doc_cpf' => [
                'type'           => 'VARCHAR',
                'constraint'     => '14'
            ],
            'password' => [
                'type'           => 'TEXT',
                'null'           => true
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true
            ],
            'user_administrator'          => [
                'type'           => 'INTEGER',
            ],
            'user_image' => [
                'type'           => 'TEXT',
                'null'           => true
            ],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('user');

        // Create default user
        $this->db->table('user')->insert([
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            'name' => "USUÁRIO PADRÃO DO SISTEMA",
            'user_administrator' => 1,
            'doc_cpf' => "111.111.111-11"
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
