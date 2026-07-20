<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table      = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_pemesanan',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran'
    ];

    public function getPembayaran($keyword = null, $status = null, $bulan = null, $tahun = null, $perPage = 10)
    {
        $builder = $this->select("
        pemesanan.id_pemesanan,
        pembayaran.id_pembayaran,
        COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan) AS tanggal_pembayaran,
        COALESCE(pembayaran.jumlah_pembayaran,kamar.harga_sewa) AS jumlah_pembayaran,
        pembayaran.bukti_pembayaran,
        IFNULL(pembayaran.status_pembayaran,'Menunggu') AS status_pembayaran,
        pemesanan.status_pemesanan,
        users.nama,
        users.no_hp,
        kost.nama_kost,
        kost.alamat_kost,
        kost.lokasi_kost,
        kost.type_kost,
        kost.foto_kost,
        kamar.nomor_kamar,
        kamar.harga_sewa ");

        $builder->join('pemesanan', 'pemesanan.id_pemesanan = pembayaran.id_pemesanan', 'right');
        $builder->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen');
        $builder->join('users', 'users.id_user = konsumen.id_user');
        $builder->join('kost', 'kost.id_kost = pemesanan.id_kost');
        $builder->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar');

        $builder->where('pemesanan.status_pemesanan', 'Disetujui');

        if ($keyword) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->orLike('kamar.nomor_kamar', $keyword)
                ->groupEnd();
        }

        if ($status && $status != 'Semua') {
            if ($status == 'Menunggu') {
                $builder->where('pembayaran.id_pembayaran IS NULL', null, false);
            } else {
                $builder->where('pembayaran.status_pembayaran', $status);
            }
        }

        if ($bulan) {
            $builder->where(
                'MONTH(COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan))',
                $bulan,
                false
            );
        }

        if ($tahun) {
            $builder->where(
                'YEAR(COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan))',
                $tahun,
                false
            );
        }

        $builder->orderBy(
            'COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan)',
            'DESC',
            false
        );

        return $builder->paginate($perPage);
    }

    public function getDetailPembayaran($id)
    {
        return $this->select("
                pembayaran.*,
                users.nama,
                users.no_hp,
                konsumen.alamat,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.type_kost,
                kost.foto_kost,
                pemesanan.tanggal_pemesanan,
                pemesanan.status_pemesanan,
                kamar.nomor_kamar,
                kamar.harga_sewa,
                pemilik_kost.nama_bank,
                pemilik_kost.nomor_rekening
            ")
            ->join('pemesanan', 'pemesanan.id_pemesanan = pembayaran.id_pemesanan', 'left')
            ->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen', 'left')
            ->join('users', 'users.id_user = konsumen.id_user', 'left')
            ->join('kost', 'kost.id_kost = pemesanan.id_kost', 'left')
            ->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar', 'left')
            ->join('pemilik_kost', 'pemilik_kost.id_pemilik = kost.id_pemilik', 'left')
            ->where('pembayaran.id_pembayaran', $id)
            ->first();
    }

    public function getPembayaranByKonsumen(
        $idKonsumen,
        $keyword = null,
        $status = null,
        $bulan = null,
        $perPage = 10
    ) {
        $this->select("
        pembayaran.*,
        pemesanan.id_pemesanan,
        COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan) AS tanggal_pembayaran,
        COALESCE(pembayaran.jumlah_pembayaran,kamar.harga_sewa) AS jumlah_pembayaran,
        users.nama,
        kost.nama_kost,
        kamar.nomor_kamar
    ");

        $this->join('pemesanan', 'pemesanan.id_pemesanan=pembayaran.id_pemesanan', 'right');
        $this->join('konsumen', 'konsumen.id_konsumen=pemesanan.id_konsumen');
        $this->join('users', 'users.id_user=konsumen.id_user');
        $this->join('kost', 'kost.id_kost=pemesanan.id_kost');
        $this->join('kamar', 'kamar.id_kamar=pemesanan.id_kamar');

        $this->where('pemesanan.id_konsumen', $idKonsumen);
        $this->where('pemesanan.status_pemesanan', 'Disetujui');

        if ($keyword) {
            $this->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->orLike('kamar.nomor_kamar', $keyword)
                ->groupEnd();
        }

        if ($status && $status != 'Semua') {

            if ($status == 'Menunggu') {
                $this->where('pembayaran.id_pembayaran IS NULL', null, false);
            } else {
                $this->where('pembayaran.status_pembayaran', $status);
            }
        }

        if ($bulan) {
            $this->where(
                'MONTH(COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan))',
                $bulan,
                false
            );
        }

        $this->orderBy(
            'COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan)',
            'DESC',
            false
        );

        return $this->paginate($perPage);
    }

    public function getPembayaranByPemilik(
        $idPemilik,
        $keyword = null,
        $status = null,
        $bulan = null,
        $perPage = 10
    ) {
        $this->select("
        pembayaran.*,
        pemesanan.id_pemesanan,
        COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan) AS tanggal_pembayaran,
        COALESCE(pembayaran.jumlah_pembayaran,kamar.harga_sewa) AS jumlah_pembayaran,
        users.nama,
        kost.nama_kost,
        kamar.nomor_kamar
    ");

        $this->join('pemesanan', 'pemesanan.id_pemesanan=pembayaran.id_pemesanan', 'right');
        $this->join('konsumen', 'konsumen.id_konsumen=pemesanan.id_konsumen');
        $this->join('users', 'users.id_user=konsumen.id_user');
        $this->join('kost', 'kost.id_kost=pemesanan.id_kost');
        $this->join('kamar', 'kamar.id_kamar=pemesanan.id_kamar');

        $this->where('kost.id_pemilik', $idPemilik);
        $this->where('pemesanan.status_pemesanan', 'Disetujui');

        if ($keyword) {
            $this->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->orLike('kamar.nomor_kamar', $keyword)
                ->groupEnd();
        }

        if ($status && $status != 'Semua') {

            if ($status == 'Menunggu') {
                $this->where('pembayaran.id_pembayaran IS NULL', null, false);
            } else {
                $this->where('pembayaran.status_pembayaran', $status);
            }
        }

        if ($bulan) {
            $this->where(
                'MONTH(COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan))',
                $bulan,
                false
            );
        }

        $this->orderBy(
            'COALESCE(pembayaran.tanggal_pembayaran,pemesanan.tanggal_pemesanan)',
            'DESC',
            false
        );

        return $this->paginate($perPage);
    }
}
