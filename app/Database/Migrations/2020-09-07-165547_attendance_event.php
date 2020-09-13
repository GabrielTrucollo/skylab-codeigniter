<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttendanceEvent extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'attendance_event_id'=> [
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
                'type'           => 'DATE',
                'null'           => true
            ],
            'start_time'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '5',
                'null'           => true
            ],
            'end_date'       => [
                'type'           => 'DATE',
                'null'           => true
            ],
            'end_time'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '5',
                'null'           => true
            ],
            'situation'       => [
                'type'           => 'INTEGER',
            ],
            'description'       => [
                'type'           => 'TEXT',
            ],
            'user_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ],
            'attendance_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ],
            'attendance_type_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ],
        ]);

        $this->forge->addForeignKey('user_id','user','user_id');
        $this->forge->addForeignKey('attendance_id','attendance','attendance_id');
        $this->forge->addForeignKey('attendance_type_id','attendance_type','attendance_type_id');
        $this->forge->addKey('attendance_event_id', true);
        $this->forge->createTable('attendance_event');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('attendance_event');
	}
}
