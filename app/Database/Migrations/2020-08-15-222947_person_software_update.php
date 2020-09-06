<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PersonSoftwareUpdate extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'person_software_update_id'          => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'created_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'updated_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'software_id'          => [
                'type'           => 'BIGINT',
            ],
            'user_id'          => [
                'type'           => 'BIGINT',
            ],
            'version'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ]
        ]);
        $this->forge->addKey('person_software_update_id', true);
        $this->forge->addForeignKey('software_id','software','software_id');
        $this->forge->addForeignKey('user_id','user','user_id');
        $this->forge->createTable('person_software_update');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('person_software_update');
	}
}
