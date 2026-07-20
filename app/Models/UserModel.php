<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'role_id',
        'nama',
        'username',
        'password',
        'no_hp',
        'foto',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getUserRole()
    {
        return $this->select('users.*, user_role.role')
                    ->join('user_role', 'user_role.role_id = users.role_id')
                    ->findAll();
    }

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getPengguna($keyword = null, $role = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
                users.*
            ");
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama', $keyword)
                ->orLike('username', $keyword)
                ->orLike('no_hp', $keyword)
                ->groupEnd();
        }

        if (!empty($role)) {
            $builder->where('role_id', $role);
        }

        // Filter Status
        if (!empty($status)) {
            $builder->where('status', $status);
        }

        $builder->orderBy('id_user', 'DESC');

        return $builder->paginate($perPage);
    }
}
