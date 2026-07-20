<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_konsumen',
        'id_kost',
        'id_kamar',
        'tanggal_pemesanan',
        'status_pemesanan'
    ];

    public function getPemesanan($keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
                pemesanan.*,
                pemesanan.id_konsumen,
                kost.nama_kost,
                users.nama,
                konsumen.alamat,
                kamar.nomor_kamar
            ")
            ->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen', 'left')
            ->join('users', 'users.id_user = konsumen.id_user', 'left')
            ->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar', 'left')
            ->join('kost', 'kost.id_kost = kamar.id_kost', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('users.nama', $keyword)
                    ->orLike('kost.nama_kost', $keyword)
                    ->orLike('kamar.nomor_kamar', $keyword)
                    ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('pemesanan.status_pemesanan', $status);
        }
        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');
        return $builder->paginate($perPage);
    }

    public function getDetailPemesanan($id)
    {
        return $this->select("
                pemesanan.*,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.type_kost,
                kost.foto_kost,
                kost.total_kamar,
                users.nama,
                users.no_hp,
                konsumen.alamat as alamat_konsumen,
                kamar.nomor_kamar,
                kamar.harga_sewa,
                tipe_kamar.nama_tipe_kamar,
                fasilitas_kamar.nama_fasilitas,
                GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') AS fasilitas_kost,
                GROUP_CONCAT(DISTINCT aturan_kost.nama_aturan SEPARATOR ', ') AS aturan_kost
            ")
            ->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen', 'left')
            ->join('users', 'users.id_user = konsumen.id_user', 'left')
            ->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar', 'left')
            ->join('kost', 'kost.id_kost = kamar.id_kost', 'left')
            ->join('tipe_kamar', 'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar', 'left')
            ->join('fasilitas_kamar', 'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar', 'left')
            ->join('detail_fasilitas_kost', 'detail_fasilitas_kost.id_kost = kost.id_kost', 'left')
            ->join('fasilitas_kost', 'fasilitas_kost.id_fasilitas_kost = detail_fasilitas_kost.id_fasilitas_kost', 'left')
            ->join('detail_aturan_kost', 'detail_aturan_kost.id_kost = kost.id_kost', 'left')
            ->join('aturan_kost', 'aturan_kost.id_aturan = detail_aturan_kost.id_aturan', 'left')
            ->where('pemesanan.id_pemesanan', $id)
            ->groupBy('pemesanan.id_pemesanan')
            ->first();
    }

    public function getPemesananByKonsumen($idKonsumen, $keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
                pemesanan.*,
                pemesanan.id_konsumen,
                kost.nama_kost,
                users.nama,
                konsumen.alamat,
                kamar.nomor_kamar
            ")
            ->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen', 'left')
            ->join('users', 'users.id_user = konsumen.id_user', 'left')
            ->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar', 'left')
            ->join('kost', 'kost.id_kost = kamar.id_kost', 'left')
            ->where('pemesanan.id_konsumen', $idKonsumen);

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('users.nama', $keyword)
                    ->orLike('kost.nama_kost', $keyword)
                    ->orLike('kamar.nomor_kamar', $keyword)
                    ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('pemesanan.status_pemesanan', $status);
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');
        return $builder->paginate($perPage);
    }

    public function getPemesananByPemilik($idPemilik, $keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
            pemesanan.*,
            pemesanan.id_konsumen,
            kost.nama_kost,
            users.nama,
            konsumen.alamat,
            kamar.nomor_kamar
        ")
            ->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen', 'left')
            ->join('users', 'users.id_user = konsumen.id_user', 'left')
            ->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar', 'left')
            ->join('kost', 'kost.id_kost = kamar.id_kost', 'left')
            ->join('pemilik_kost', 'pemilik_kost.id_pemilik = kost.id_pemilik', 'left')
            ->where('pemilik_kost.id_pemilik', $idPemilik);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->orLike('kamar.nomor_kamar', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('pemesanan.status_pemesanan', $status);
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');
        return $builder->paginate($perPage);
    }
}
