<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Person extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'person_id'          => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'created_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'updated_at'       => [
                'type'           => 'TIMESTAMP',
            ],
            'status' => [
                'type'           => 'INTEGER',
                'default'        => '0'
            ],
            'company_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'fantasy_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true
            ],
            'doc_cpf_cnpj' => [
                'type'           => 'VARCHAR',
                'constraint'     => '18'
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true
            ],
            'phone' => [
                'type'           => 'VARCHAR',
                'constraint'     => '18',
                'null'           => true
            ],
            'flag_client' => [
                'type'           => 'BOOLEAN',
            ],
            'flag_accounting' => [
                'type'           => 'BOOLEAN',
            ],
            'address_street' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true
            ],
            'address_neighborhood' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true
            ],
            'address_number' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => true
            ],
            'address_zipcode' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => true
            ],
            'address_city' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => true
            ],
            'address_state' => [
                'type'           => 'VARCHAR',
                'constraint'     => '2',
                'null'           => true
            ],
            'address_reference' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => true
            ],
            'software_id'       => [
                'type'           => 'BIGINT',
            ],
            'accounting_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ],
            'payment_type_id'       => [
                'type'           => 'BIGINT',
                'null'           => true
            ]
        ]);
        $this->forge->addKey('person_id', true);
        $this->forge->addForeignKey('software_id','software','software_id');
        $this->forge->addForeignKey('payment_type_id','payment_type','payment_type_id');
        $this->forge->addForeignKey('accounting_id','person','person_id');
        $this->forge->createTable('person');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('person');
	}
}
