<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttendanceReason extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'attendance_reason_id'=> [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'created_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'updated_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'description'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ]
        ]);
        $this->forge->addKey('attendance_reason_id', true);
        $this->forge->createTable('attendance_reason');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('attendance_reason');
	}
}
