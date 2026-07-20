<?php

namespace App\Models;

use CodeIgniter\Model;

class PenghuniModel extends Model
{
    protected $table      = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    protected $returnType = 'array';

    public function getPenghuni($keyword = null, $perPage = 10)
    {
        $builder = $this->select("
            pemesanan.*,
            users.nama,
            users.no_hp,
            konsumen.alamat,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kamar.nomor_kamar,
            kamar.harga_sewa,
            kamar.status_ketersediaan,
            tipe_kamar.nama_tipe_kamar,
            fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
            pembayaran.status_pembayaran,
            pembayaran.jumlah_pembayaran,
            pembayaran.tanggal_pembayaran
        ");

        $builder->join(
            'konsumen',
            'konsumen.id_konsumen = pemesanan.id_konsumen'
        );

        $builder->join(
            'users',
            'users.id_user = konsumen.id_user'
        );

        $builder->join(
            'kost',
            'kost.id_kost = pemesanan.id_kost'
        );

        $builder->join(
            'kamar',
            'kamar.id_kamar = pemesanan.id_kamar'
        );

        $builder->join(
            'tipe_kamar',
            'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar',
            'left'
        );

        $builder->join(
            'fasilitas_kamar',
            'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar',
            'left'
        );

        $builder->join(
            'pembayaran',
            'pembayaran.id_pemesanan = pemesanan.id_pemesanan',
            'left'
        );

        $builder->whereIn('pemesanan.status_pemesanan', [
            'Disetujui',
            'Berhenti_Sewa'
        ]);

        $builder->where('pembayaran.status_pembayaran', 'Disetujui');

        if (!empty($keyword)) {

            $builder->groupStart();

            $builder->like('users.nama', $keyword);
            $builder->orLike('kost.nama_kost', $keyword);
            $builder->orLike('kamar.nomor_kamar', $keyword);

            $builder->groupEnd();
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');

        return $builder->paginate($perPage);
    }

    public function getPenghuniDetail($id)
    {
        return $this->select("
            pemesanan.*,
            users.nama,
            users.no_hp,
            konsumen.alamat,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kost.total_kamar,
            kamar.nomor_kamar,
            kamar.harga_sewa,
            kamar.status_ketersediaan,
            tipe_kamar.nama_tipe_kamar,
            fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
            pembayaran.status_pembayaran,
            pembayaran.jumlah_pembayaran,
            pembayaran.tanggal_pembayaran,
            GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') AS fasilitas_kost,
            GROUP_CONCAT(DISTINCT aturan_kost.nama_aturan SEPARATOR ', ') AS aturan_kost
        ")

        ->join(
            'konsumen',
            'konsumen.id_konsumen = pemesanan.id_konsumen'
        )

        ->join(
            'users',
            'users.id_user = konsumen.id_user'
        )

        ->join(
            'kost',
            'kost.id_kost = pemesanan.id_kost'
        )

        ->join(
            'kamar',
            'kamar.id_kamar = pemesanan.id_kamar'
        )

        ->join(
            'tipe_kamar',
            'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar',
            'left'
        )

        ->join(
            'fasilitas_kamar',
            'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar',
            'left'
        )

        ->join(
            'detail_fasilitas_kost',
            'detail_fasilitas_kost.id_kost = kost.id_kost',
            'left'
        )

        ->join(
            'fasilitas_kost',
            'fasilitas_kost.id_fasilitas_kost = detail_fasilitas_kost.id_fasilitas_kost',
            'left'
        )

        ->join(
            'detail_aturan_kost',
            'detail_aturan_kost.id_kost = kost.id_kost',
            'left'
        )

        ->join(
            'aturan_kost',
            'aturan_kost.id_aturan = detail_aturan_kost.id_aturan',
            'left'
        )

        ->join(
            'pembayaran',
            'pembayaran.id_pemesanan = pemesanan.id_pemesanan',
            'left'
        )

        ->where('pemesanan.id_pemesanan', $id)
        ->groupBy('pemesanan.id_pemesanan')

        ->first();
    }

    public function getPenghuniByKonsumen($idKonsumen, $keyword = null, $perPage = 10)
    {
        $builder = $this->select("
            pemesanan.*,
            users.nama,
            users.no_hp,
            konsumen.alamat,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kamar.nomor_kamar,
            kamar.harga_sewa,
            kamar.status_ketersediaan,
            tipe_kamar.nama_tipe_kamar,
            fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
            pembayaran.status_pembayaran,
            pembayaran.jumlah_pembayaran,
            pembayaran.tanggal_pembayaran
        ");

        $builder->join(
            'konsumen',
            'konsumen.id_konsumen = pemesanan.id_konsumen'
        );

        $builder->join(
            'users',
            'users.id_user = konsumen.id_user'
        );

        $builder->join(
            'kost',
            'kost.id_kost = pemesanan.id_kost'
        );

        $builder->join(
            'kamar',
            'kamar.id_kamar = pemesanan.id_kamar'
        );

        $builder->join(
            'tipe_kamar',
            'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar',
            'left'
        );

        $builder->join(
            'fasilitas_kamar',
            'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar',
            'left'
        );

        $builder->join(
            'pembayaran',
            'pembayaran.id_pemesanan = pemesanan.id_pemesanan',
            'left'
        );

        $builder->where('pemesanan.id_konsumen', $idKonsumen);
        $builder->whereIn('pemesanan.status_pemesanan', [
            'Disetujui',
            'Berhenti_Sewa'
        ]);
        $builder->where('pembayaran.status_pembayaran', 'Disetujui');

        if (!empty($keyword)) {
            $builder->groupStart();
            $builder->like('users.nama', $keyword);
            $builder->orLike('kost.nama_kost', $keyword);
            $builder->orLike('kamar.nomor_kamar', $keyword);
            $builder->groupEnd();
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');

        return $builder->paginate($perPage);
    }

    public function getPenghuniByPemilik($idPemilik, $keyword = null, $perPage = 10)
    {
        $builder = $this->select("
        pemesanan.*,
        users.nama,
        users.no_hp,
        konsumen.alamat,
        kost.nama_kost,
        kost.alamat_kost,
        kost.lokasi_kost,
        kost.type_kost,
        kost.foto_kost,
        kamar.nomor_kamar,
        kamar.harga_sewa,
        kamar.status_ketersediaan,
        tipe_kamar.nama_tipe_kamar,
        fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
        pembayaran.status_pembayaran,
        pembayaran.jumlah_pembayaran,
        pembayaran.tanggal_pembayaran
    ");

        $builder->join('konsumen', 'konsumen.id_konsumen = pemesanan.id_konsumen');
        $builder->join('users', 'users.id_user = konsumen.id_user');
        $builder->join('kost', 'kost.id_kost = pemesanan.id_kost');
        $builder->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar');
        $builder->join('tipe_kamar', 'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar', 'left');
        $builder->join('fasilitas_kamar', 'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar', 'left');
        $builder->join('pembayaran', 'pembayaran.id_pemesanan = pemesanan.id_pemesanan', 'left');

        $builder->where('kost.id_pemilik', $idPemilik);
        $builder->whereIn('pemesanan.status_pemesanan', [
            'Disetujui',
            'Berhenti_Sewa'
        ]);
        $builder->where('pembayaran.status_pembayaran', 'Disetujui');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->orLike('kamar.nomor_kamar', $keyword)
            ->groupEnd();
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');

        return $this->paginate($perPage);
    }

    public function getAllPenghuni($keyword = null)
    {
        $builder = $this->select("
            pemesanan.*,
            users.nama,
            users.no_hp,
            konsumen.alamat,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kamar.nomor_kamar,
            kamar.harga_sewa,
            kamar.status_ketersediaan,
            tipe_kamar.nama_tipe_kamar,
            fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
            pembayaran.status_pembayaran,
            pembayaran.jumlah_pembayaran,
            pembayaran.tanggal_pembayaran
        ");

        $builder->join(
            'konsumen',
            'konsumen.id_konsumen = pemesanan.id_konsumen'
        );

        $builder->join(
            'users',
            'users.id_user = konsumen.id_user'
        );

        $builder->join(
            'kost',
            'kost.id_kost = pemesanan.id_kost'
        );

        $builder->join(
            'kamar',
            'kamar.id_kamar = pemesanan.id_kamar'
        );

        $builder->join(
            'tipe_kamar',
            'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar',
            'left'
        );

        $builder->join(
            'fasilitas_kamar',
            'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar',
            'left'
        );

        $builder->join(
            'pembayaran',
            'pembayaran.id_pemesanan = pemesanan.id_pemesanan',
            'left'
        );

        $builder->whereIn('pemesanan.status_pemesanan', [
            'Disetujui',
            'Berhenti Sewa'
        ]);

        $builder->where('pembayaran.status_pembayaran', 'Disetujui');

        if (!empty($keyword)) {
            $builder->groupStart();
            $builder->like('users.nama', $keyword);
            $builder->orLike('kost.nama_kost', $keyword);
            $builder->orLike('kamar.nomor_kamar', $keyword);
            $builder->groupEnd();
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function getAllPenghuniByPemilik($idPemilik, $keyword = null)
    {
        $builder = $this->select("
            pemesanan.*,
            users.nama,
            users.no_hp,
            konsumen.alamat,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kamar.nomor_kamar,
            kamar.harga_sewa,
            kamar.status_ketersediaan,
            tipe_kamar.nama_tipe_kamar,
            fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
            pembayaran.status_pembayaran,
            pembayaran.jumlah_pembayaran,
            pembayaran.tanggal_pembayaran
        ");

        $builder->join(
            'konsumen',
            'konsumen.id_konsumen = pemesanan.id_konsumen'
        );

        $builder->join(
            'users',
            'users.id_user = konsumen.id_user'
        );

        $builder->join(
            'kost',
            'kost.id_kost = pemesanan.id_kost'
        );

        $builder->join(
            'kamar',
            'kamar.id_kamar = pemesanan.id_kamar'
        );

        $builder->join(
            'tipe_kamar',
            'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar',
            'left'
        );

        $builder->join(
            'fasilitas_kamar',
            'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar',
            'left'
        );

        $builder->join(
            'pembayaran',
            'pembayaran.id_pemesanan = pemesanan.id_pemesanan',
            'left'
        );

        $builder->where('kost.id_pemilik', $idPemilik);
        $builder->whereIn('pemesanan.status_pemesanan', [
            'Disetujui',
            'Berhenti_Sewa',
        ]);
        $builder->where('pembayaran.status_pembayaran', 'Disetujui');

        if (!empty($keyword)) {
            $builder->groupStart();
            $builder->like('users.nama', $keyword);
            $builder->orLike('kost.nama_kost', $keyword);
            $builder->orLike('kamar.nomor_kamar', $keyword);
            $builder->groupEnd();
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function getAllPenghuniByKonsumen($idKonsumen, $keyword = null)
    {
        $builder = $this->select("
            pemesanan.*,
            users.nama,
            users.no_hp,
            konsumen.alamat,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kamar.nomor_kamar,
            kamar.harga_sewa,
            kamar.status_ketersediaan,
            tipe_kamar.nama_tipe_kamar,
            fasilitas_kamar.nama_fasilitas AS fasilitas_kamar,
            pembayaran.status_pembayaran,
            pembayaran.jumlah_pembayaran,
            pembayaran.tanggal_pembayaran
        ");

        $builder->join(
            'konsumen',
            'konsumen.id_konsumen = pemesanan.id_konsumen'
        );

        $builder->join(
            'users',
            'users.id_user = konsumen.id_user'
        );

        $builder->join(
            'kost',
            'kost.id_kost = pemesanan.id_kost'
        );

        $builder->join(
            'kamar',
            'kamar.id_kamar = pemesanan.id_kamar'
        );

        $builder->join(
            'tipe_kamar',
            'tipe_kamar.id_tipe_kamar = kamar.id_tipe_kamar',
            'left'
        );

        $builder->join(
            'fasilitas_kamar',
            'fasilitas_kamar.id_fasilitas_kamar = kamar.id_fasilitas_kamar',
            'left'
        );

        $builder->join(
            'pembayaran',
            'pembayaran.id_pemesanan = pemesanan.id_pemesanan',
            'left'
        );

        $builder->where('pemesanan.id_konsumen', $idKonsumen);
        $builder->whereIn('pemesanan.status_pemesanan', [
            'Disetujui',
            'Berhenti_Sewa'
        ]);
        $builder->where('pembayaran.status_pembayaran', 'Disetujui');

        if (!empty($keyword)) {
            $builder->groupStart();
            $builder->like('users.nama', $keyword);
            $builder->orLike('kost.nama_kost', $keyword);
            $builder->orLike('kamar.nomor_kamar', $keyword);
            $builder->groupEnd();
        }

        $builder->orderBy('pemesanan.id_pemesanan', 'DESC');

        return $builder->get()->getResultArray();
    }
}
