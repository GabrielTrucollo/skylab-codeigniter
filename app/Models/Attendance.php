<?php

namespace App\Models;

use CodeIgniter\Model;

class Attendance extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'attendance';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'attendance_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'start_date',
        'end_date',
        'situation',
        'description',
        'person_id',
        'user_id',
        'attendance_reason_id',
        'attendance_scheduling_id'];

    protected $returnType = 'App\Entities\Attendance';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}