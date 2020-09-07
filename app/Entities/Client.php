<?php namespace App\Entities;

use CodeIgniter\Entity;

class Client extends Entity
{
    protected $casts = [
        'flag_client' => 'boolean'
    ];
}