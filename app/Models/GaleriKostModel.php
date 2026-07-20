<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriKostModel extends Model
{
    protected $table            = 'galeri_kost';
    protected $primaryKey       = 'id_foto';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_kost',
        'nama_file',
        'urutan'
    ];
}
