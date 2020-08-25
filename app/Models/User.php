<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'user_id,
         name,
         doc_cpf,
         user_image,
         user_administrator,
         user_image,
         email'];
}