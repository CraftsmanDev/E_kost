<?php

namespace App\Models;

use CodeIgniter\Model;

class KostModel extends Model
{
    protected $table = 'kost';
    protected $primaryKey = 'id_kost';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_pemilik',
        'id_fasilitas_kost',
        'id_aturan',
        'nama_kost',
        'alamat_kost',
        'lokasi_kost',
        'latitude',
        'longitude',
        'foto_kost',
        'type_kost',
        'total_kamar'
    ];

    public function GetKost($keyword = null, $tipe = null, $status = null, $perPage = 5)
    {
        $builder = $this->select("
            kost.*,
            users.nama AS nama_pemilik,
            COUNT(DISTINCT CASE
                WHEN kamar.status_ketersediaan = 'Tersedia'
                THEN kamar.id_kamar
            END) AS kamar_terisi,
            MIN(kamar.harga_sewa) AS harga,
            CASE
                WHEN SUM(
                    CASE
                        WHEN kamar.status_ketersediaan = 'Tersedia'
                        THEN 1
                        ELSE 0
                    END
                ) > 0
                THEN 'Tersedia'
                ELSE 'Penuh'
            END AS status_ketersediaan
        ");

        $builder->join('pemilik_kost', 'pemilik_kost.id_pemilik = kost.id_pemilik');
        $builder->join('users', 'users.id_user = pemilik_kost.id_user');
        $builder->join('kamar', 'kamar.id_kost = kost.id_kost', 'left');

        $builder->join(
            'detail_fasilitas_kost',
            'detail_fasilitas_kost.id_kost = kost.id_kost',
            'left'
        );

        $builder->join(
            'fasilitas_kost',
            'fasilitas_kost.id_fasilitas_kost = detail_fasilitas_kost.id_fasilitas_kost',
            'left'
        );

        $builder->select("
            GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') AS fasilitas
        ");

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('kost.nama_kost', $keyword)
                    ->orLike('kost.alamat_kost', $keyword)
                    ->orLike('kost.lokasi_kost', $keyword)
                    ->orLike('users.nama', $keyword)
                    ->groupEnd();
        }

        if (!empty($tipe)) {
            $builder->where('kost.type_kost', $tipe);
        }

        if (!empty($status)) {
            $builder->having('status_ketersediaan', $status);
        }

        $builder->groupBy('kost.id_kost');

        return $builder->paginate($perPage);
    }

    public function getDetailKost($id)
    {
        $kost = $this->db->table('kost')
            ->select("
                kost.*,
                users.nama AS nama_pemilik,
                COUNT(DISTINCT CASE
                    WHEN kamar.status_ketersediaan = 'tersedia'
                    THEN kamar.id_kamar
                END) AS kamar_terisi,
                MIN(kamar.harga_sewa) AS harga
            ")
            ->join('pemilik_kost', 'pemilik_kost.id_pemilik = kost.id_pemilik')
            ->join('users', 'users.id_user = pemilik_kost.id_user')
            ->join('kamar', 'kamar.id_kost = kost.id_kost', 'left')
            ->where('kost.id_kost', $id)
            ->groupBy('kost.id_kost')
            ->get()
            ->getRowArray();
        if (!$kost) {
            return null;
        }
        $kost['fasilitas'] = $this->db->table('detail_fasilitas_kost')
            ->select('fasilitas_kost.id_fasilitas_kost, fasilitas_kost.nama_fasilitas')
            ->join(
                'fasilitas_kost',
                'fasilitas_kost.id_fasilitas_kost = detail_fasilitas_kost.id_fasilitas_kost'
            )
            ->where('detail_fasilitas_kost.id_kost', $id)
            ->get()
            ->getResultArray();
        $kost['aturan'] = $this->db->table('detail_aturan_kost')
            ->select('aturan_kost.id_aturan, aturan_kost.nama_aturan, aturan_kost.deskripsi_aturan')
            ->join(
                'aturan_kost',
                'aturan_kost.id_aturan = detail_aturan_kost.id_aturan'
            )
            ->where('detail_aturan_kost.id_kost', $id)
            ->get()
            ->getResultArray();

        return $kost;
    }

    public function hapusKost($id)
    {
        return $this->db->table('kost')
            ->where('id_kost', $id)
            ->delete();
    }

    public function getKostByPemilik($idPemilik, $keyword = null, $tipe = null, $status = null, $perPage = 5)
    {
        $builder = $this->select("
            kost.*,
            users.nama AS nama_pemilik,
            COUNT(DISTINCT CASE
                WHEN kamar.status_ketersediaan = 'Tersedia'
                THEN kamar.id_kamar
            END) AS kamar_terisi,
            MIN(kamar.harga_sewa) AS harga,
            CASE
                WHEN SUM(
                    CASE
                        WHEN kamar.status_ketersediaan = 'Tersedia'
                        THEN 1
                        ELSE 0
                    END
                ) > 0
                THEN 'Tersedia'
                ELSE 'Penuh'
            END AS status_ketersediaan
        ");

        $builder->join('pemilik_kost', 'pemilik_kost.id_pemilik = kost.id_pemilik');
        $builder->join('users', 'users.id_user = pemilik_kost.id_user');
        $builder->join('kamar', 'kamar.id_kost = kost.id_kost', 'left');

        $builder->join(
            'detail_fasilitas_kost',
            'detail_fasilitas_kost.id_kost = kost.id_kost',
            'left'
        );

        $builder->join(
            'fasilitas_kost',
            'fasilitas_kost.id_fasilitas_kost = detail_fasilitas_kost.id_fasilitas_kost',
            'left'
        );

        $builder->select("
            GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') AS fasilitas
        ");

        $builder->where('pemilik_kost.id_pemilik', $idPemilik);

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('kost.nama_kost', $keyword)
                    ->orLike('kost.alamat_kost', $keyword)
                    ->orLike('kost.lokasi_kost', $keyword)
                    ->orLike('users.nama', $keyword)
                    ->groupEnd();
        }

        if (!empty($tipe)) {
            $builder->where('kost.type_kost', $tipe);
        }

        $builder->groupBy('kost.id_kost');

        return $builder->paginate($perPage);
    }
}
