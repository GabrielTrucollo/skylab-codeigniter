<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceEvent extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'attendance_event';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'attendance_event_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'end_date',
        'end_time',
        'situation',
        'description',
        'user_id',
        'attendance_id',
        'attendance_type_id'];

    protected $returnType = 'App\Entities\AttendanceEvent';

    /**
     * Indicate if table user default timesatmps
     * @var bool
     */
    protected $useTimestamps = true;
}