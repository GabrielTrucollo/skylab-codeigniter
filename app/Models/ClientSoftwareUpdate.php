<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientSoftwareUpdate extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'person_software_update';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'person_software_update_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'person_id',
        'software_id',
        'user_id',
        'version'];

    protected $returnType = 'App\Entities\ClientSoftwareUpdate';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}