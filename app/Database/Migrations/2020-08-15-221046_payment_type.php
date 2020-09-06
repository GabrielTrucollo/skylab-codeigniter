<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentType extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'payment_type_id'=> [
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
                'constraint'     => '50',
            ],
            'disabled' => [
                'type'           => 'BOOLEAN',
            ]
        ]);
        $this->forge->addKey('payment_type_id', true);
        $this->forge->createTable('payment_type');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('payment_type');
	}
}
