<?php

namespace App\Models;

use CodeIgniter\Model;

class TipeKamarModel extends Model
{
    protected $table            = 'tipe_kamar';
    protected $primaryKey       = 'id_tipe_kamar';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama_tipe_kamar',
        'deskripsi_type'
    ];
    public function getTipeKamar()
    {
        return $this->orderBy('nama_tipe_kamar', 'ASC')
                    ->findAll();
    }
    public function search($keyword = null, $perPage = 10)
    {
        $builder = $this;

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('nama_tipe_kamar', $keyword)
                    ->orLike('deskripsi_type', $keyword)
                    ->groupEnd();
        }

        return $builder->paginate($perPage);
    }
}