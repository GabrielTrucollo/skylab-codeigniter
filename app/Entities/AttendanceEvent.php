<?php namespace App\Entities;

use CodeIgniter\Entity;

class AttendanceEvent extends Entity
{
    protected $casts = [
        'start_date' => '?date',
        'start_time' => '?time',
        'end_date' => '?date',
        'end_time' => '?time',
    ];
}