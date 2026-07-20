<?php

namespace App\Models;

use CodeIgniter\Model;

class AturanKostModel extends Model
{
    protected $table = 'aturan_kost';
    protected $primaryKey = 'id_aturan';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_aturan',
        'deskripsi_aturan'
    ];

    public function getAturan($keyword = null, $perPage = 10)
    {
        $builder = $this->builder();

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('nama_aturan', $keyword)
                    ->orLike('deskripsi_aturan', $keyword)
                    ->groupEnd();
        }

        $builder->orderBy('id_aturan', 'DESC');

        return $builder->paginate($perPage);
    }
}