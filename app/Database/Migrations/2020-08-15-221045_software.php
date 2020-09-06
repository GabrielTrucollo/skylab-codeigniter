<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Software extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'software_id'          => [
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
                'constraint'     => '50',
            ],
            'disabled' => [
                'type'           => 'BOOLEAN',
            ]
        ]);
        $this->forge->addKey('software_id', true);
        $this->forge->createTable('software');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('software');
	}
}
