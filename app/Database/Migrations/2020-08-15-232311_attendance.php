<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Attendance extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'attendance_id'=> [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'created_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'updated_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'start_date'       => [
                'type'           => 'TIMESTAMP',
                'null'           => true
            ],
            'end_date'       => [
                'type'           => 'TIMESTAMP',
                'null'           => true
            ],
            'time'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '8',
                'null'           => true
            ],
            'situation'       => [
                'type'           => 'INTEGER',
            ],
            'description'       => [
                'type'           => 'TEXT',
            ],
            'solution'       => [
                'type'           => 'TEXT',
            ],
            'person_id'       => [
                'type'           => 'BIGINT',
            ],
            'user_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ],
            'attendance_reason_id'       => [
                'type'           => 'BIGINT',
            ],
            'attendance_scheduling_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ]
        ]);

        $this->forge->addForeignKey('person_id','person','person_id');
        $this->forge->addForeignKey('user_id','user','user_id');
        $this->forge->addForeignKey('attendance_reason_id','attendance_reason','attendance_reason_id');
        $this->forge->addForeignKey('attendance_scheduling_id','attendance_scheduling','attendance_scheduling_id');
        $this->forge->addKey('attendance_id', true);
        $this->forge->createTable('attendance');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('attendance');
	}
}
