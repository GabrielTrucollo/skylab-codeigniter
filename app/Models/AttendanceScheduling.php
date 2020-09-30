<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceScheduling extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'attendance_scheduling';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'attendance_scheduling_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'reason',
        'start_date',
        'start_hour',
        'end_date',
        'end_hour',
        'user_id',
        'person_id'];

    protected $returnType = 'App\Entities\AttendanceEvent';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}