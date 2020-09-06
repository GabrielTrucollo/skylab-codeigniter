<?php

namespace App\Models;

use CodeIgniter\Model;

class Software extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'software';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'software_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'name',
        'status'];

    protected $returnType = 'App\Entities\Software';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}