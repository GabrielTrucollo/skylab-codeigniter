<?php namespace App\Entities;

use CodeIgniter\Entity;

class Accounting extends Entity
{
    protected $casts = [
        'flag_accounting' => 'boolean'
    ];
}