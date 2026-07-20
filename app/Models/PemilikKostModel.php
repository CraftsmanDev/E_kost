<?php

namespace App\Models;

use CodeIgniter\Model;

class PemilikKostModel extends Model
{
    protected $table = 'pemilik_kost';
    protected $primaryKey = 'id_pemilik';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_user',
        'alamat',
        'nama_bank',
        'nomor_rekening'
    ];

    public function getPemilik()
    {
        return $this->select('pemilik_kost.*, users.nama, users.no_hp')
                    ->join('users', 'users.id_user = pemilik_kost.id_user')
                    ->findAll();
    }
}