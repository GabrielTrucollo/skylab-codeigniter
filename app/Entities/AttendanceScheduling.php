<?php namespace App\Entities;

use CodeIgniter\Entity;

class AttendanceScheduling extends Entity
{
    protected $casts = [
        'date_visit' => '?Date',
        'hour_visit' => '?Time'
    ];
}