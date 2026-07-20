<?php

namespace App\Models;

use CodeIgniter\Model;

class FasilitasKostModel extends Model
{
    protected $table = 'fasilitas_kost';
    protected $primaryKey = 'id_fasilitas_kost';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_fasilitas',
        'deskripsi'
    ];

    public function getFasilitas($keyword = null, $perPage = 10)
    {
        $builder = $this->builder();

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('nama_fasilitas', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->groupEnd();
        }

        $builder->orderBy('id_fasilitas_kost', 'DESC');

        return $builder->paginate($perPage);
    }
}