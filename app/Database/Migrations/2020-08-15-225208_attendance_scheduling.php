<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttendanceScheduling extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'attendance_scheduling_id'=> [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'created_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'updated_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'reason'       => [
                'type'           => 'TEXT',
                'null'           => true
            ],
            'start_date'       => [
                'type'           => 'DATE',
            ],
            'start_hour'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '5',
            ],
            'end_date'       => [
                'type'           => 'DATE',
            ],
            'end_hour'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '5',
            ],
            'person_id'=> [
                'type'           => 'BIGINT',
            ],
            'user_id'=> [
                'type'           => 'BIGINT',
            ],
        ]);
        $this->forge->addForeignKey('user_id','user','user_id');
        $this->forge->addForeignKey('person_id','person','person_id');
        $this->forge->addKey('attendance_scheduling_id', true);
        $this->forge->createTable('attendance_scheduling');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('attendance_scheduling');
	}
}
