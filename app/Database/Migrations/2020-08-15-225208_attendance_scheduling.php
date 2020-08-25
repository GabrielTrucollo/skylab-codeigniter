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
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true
            ],
            'date_visit'       => [
                'type'           => 'DATE',
            ],
            'hour_visit'       => [
                'type'           => 'VARHCAR',
                'constraint'     => '5',
            ],
            'user_id'=> [
                'type'           => 'BIGINT',
            ],
        ]);
        $this->forge->addForeignKey('user_id','user','user_id');
        $this->forge->addKey('attendance_scheduling_id', true);
        $this->forge->createTable('attendance_scheduling');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('attendance_scheduling');
	}
}
