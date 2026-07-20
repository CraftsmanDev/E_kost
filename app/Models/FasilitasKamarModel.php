<?php

namespace App\Models;

use CodeIgniter\Model;

class FasilitasKamarModel extends Model
{
    protected $table            = 'fasilitas_kamar';
    protected $primaryKey       = 'id_fasilitas_kamar';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama_fasilitas',
        'deskripsi'
    ];
    public function getFasilitasKamar()
    {
        return $this->orderBy('nama_fasilitas', 'ASC')
                    ->findAll();
    }
    public function search($keyword = null, $perPage = 10)
    {
        $builder = $this;
        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('nama_fasilitas', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->groupEnd();
        }

        return $builder->paginate($perPage);
    }
    public function getById($id)
    {
        return $this->find($id);
    }
}
