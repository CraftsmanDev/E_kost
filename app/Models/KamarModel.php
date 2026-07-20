<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_kost',
        'id_tipe_kamar',
        'id_fasilitas_kamar',
        'harga_sewa',
        'status_ketersediaan',
        'nomor_kamar'
    ];

    public function getDetailKamar($id)
    {
        return $this->db->table('kamar')
            ->select("
                kamar.*,
                tipe_kamar.nama_tipe_kamar,
                fasilitas_kamar.nama_fasilitas
            ")
            ->join(
                'tipe_kamar',
                'tipe_kamar.id_tipe_kamar=kamar.id_tipe_kamar'
            )
            ->join(
                'fasilitas_kamar',
                'fasilitas_kamar.id_fasilitas_kamar=kamar.id_fasilitas_kamar'
            )
            ->where('id_kost', $id)
            ->get()
            ->getResultArray();
    }

    public function getKamarByKost($id_kost, $keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
                kamar.*,
                tipe_kamar.nama_tipe_kamar,
                fasilitas_kamar.nama_fasilitas
            ")
            ->join('tipe_kamar', 'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar')
            ->join('fasilitas_kamar', 'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar')
            ->where('kamar.id_kost', $id_kost);

        if (!empty($keyword)) {
            $builder->like('kamar.nomor_kamar', $keyword);
        }

        if (!empty($status)) {
            $builder->where('kamar.status_ketersediaan', $status);
        }

        return $builder->paginate($perPage);
    }

    public function getKamarStats($id_kost)
    {
        $total = $this->where('id_kost', $id_kost)->countAllResults();
        $tersedia = $this->where('id_kost', $id_kost)->where('status_ketersediaan', 'Tersedia')->countAllResults();
        $terisi = $this->where('id_kost', $id_kost)->where('status_ketersediaan', 'Terisi')->countAllResults();

        return [
            'total' => $total,
            'tersedia' => $tersedia,
            'terisi' => $terisi
        ];
    }

    public function hapusKamar($id)
    {
        return $this->db->table('kamar')
            ->where('id_kost', $id)
            ->delete();
    }
}
