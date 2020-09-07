<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'person';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'person_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'status',
        'company_name',
        'fantasy_name',
        'doc_cpf_cnpj',
        'email',
        'phone',
        'flag_client',
        'address_street',
        'address_neighborhood',
        'address_number',
        'address_zipcode',
        'address_city',
        'address_state',
        'address_reference',
        'software_id',
        'accounting_id',
        'payment_type_id'];

    protected $returnType = 'App\Entities\Client';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}