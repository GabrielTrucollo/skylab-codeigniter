<?php namespace App\Entities;

use CodeIgniter\Entity;

class Attendance extends Entity
{
    protected $casts = [
        'start_date' => '?datetime',
        'end_date' => '?datetime',
    ];
}