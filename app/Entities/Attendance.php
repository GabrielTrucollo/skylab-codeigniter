<?php namespace App\Entities;

use CodeIgniter\Entity;

class Attendance extends Entity
{
    protected $casts = [
        'start_date' => '?date',
        'start_time' => '?time',
        'end_date' => '?datetime',
    ];
}