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
}