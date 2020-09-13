<?php namespace App\Entities;

use CodeIgniter\Entity;

class AttendanceEvent extends Entity
{
    protected $casts = [
        'end_date' => '?date',
        'end_time' => '?time',
    ];
}