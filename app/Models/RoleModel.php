<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'user_role';
    protected $primaryKey = 'role_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'role'
    ];
}