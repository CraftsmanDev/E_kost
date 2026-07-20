<?php

namespace App\Models;

use CodeIgniter\Model;

class KonsumenModel extends Model
{
    protected $table = 'konsumen';
    protected $primaryKey = 'id_konsumen';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_user',
        'alamat'
    ];

    public function getKonsumen()
    {
        return $this->select('konsumen.*, users.nama, users.no_hp')
                    ->join('users', 'users.id_user = konsumen.id_user')
                    ->findAll();
    }
}