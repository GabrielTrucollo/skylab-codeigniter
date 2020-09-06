<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentType extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'payment_type';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'payment_type_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'description',
        'status'];

    protected $returnType = 'App\Entities\PaymentType';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}