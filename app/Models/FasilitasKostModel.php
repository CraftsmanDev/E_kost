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
}