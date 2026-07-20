<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanBerhentiModel extends Model
{
    protected $table = 'pengajuan_berhenti_sewa';
    protected $primaryKey = 'id_pengajuan';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_pemesanan',
        'id_konsumen',
        'id_kost',
        'id_kamar',
        'tanggal_pengajuan',
        'tanggal_berhenti',
        'alasan',
        'status_pengajuan',
        'catatan_admin'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPengajuan($keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
                pengajuan_berhenti_sewa.*,
                users.nama,
                users.no_hp,
                konsumen.alamat as alamat_konsumen,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.type_kost,
                kost.foto_kost,
                kamar.nomor_kamar,
                kamar.harga_sewa
            ")
            ->join('konsumen', 'konsumen.id_konsumen = pengajuan_berhenti_sewa.id_konsumen')
            ->join('users', 'users.id_user = konsumen.id_user')
            ->join('kost', 'kost.id_kost = pengajuan_berhenti_sewa.id_kost')
            ->join('kamar', 'kamar.id_kamar = pengajuan_berhenti_sewa.id_kamar', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status_pengajuan', $status);
        }

        return $builder->paginate($perPage);
    }

    public function getDetailPengajuan($id)
    {
        return $this->select("
                pengajuan_berhenti_sewa.*,
                users.nama,
                users.no_hp,
                konsumen.alamat as alamat_konsumen,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.type_kost,
                kost.foto_kost,
                kamar.nomor_kamar,
                kamar.harga_sewa
            ")
            ->join('konsumen', 'konsumen.id_konsumen = pengajuan_berhenti_sewa.id_konsumen')
            ->join('users', 'users.id_user = konsumen.id_user')
            ->join('kost', 'kost.id_kost = pengajuan_berhenti_sewa.id_kost')
            ->join('kamar', 'kamar.id_kamar = pengajuan_berhenti_sewa.id_kamar', 'left')
            ->where('pengajuan_berhenti_sewa.id_pengajuan', $id)
            ->first();
    }

    public function getPengajuanByKonsumen($idKonsumen, $keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
                pengajuan_berhenti_sewa.*,
                users.nama,
                users.no_hp,
                konsumen.alamat as alamat_konsumen,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.type_kost,
                kost.foto_kost,
                kamar.nomor_kamar,
                kamar.harga_sewa
            ")
            ->join('konsumen', 'konsumen.id_konsumen = pengajuan_berhenti_sewa.id_konsumen')
            ->join('users', 'users.id_user = konsumen.id_user')
            ->join('kost', 'kost.id_kost = pengajuan_berhenti_sewa.id_kost')
            ->join('kamar', 'kamar.id_kamar = pengajuan_berhenti_sewa.id_kamar', 'left')
            ->where('pengajuan_berhenti_sewa.id_konsumen', $idKonsumen);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status_pengajuan', $status);
        }

        return $builder->paginate($perPage);
    }

    public function getPengajuanByPemilik($idPemilik, $keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->select("
            pengajuan_berhenti_sewa.*,
            users.nama,
            users.no_hp,
            konsumen.alamat as alamat_konsumen,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.type_kost,
            kost.foto_kost,
            kamar.nomor_kamar,
            kamar.harga_sewa
        ")
            ->join('konsumen', 'konsumen.id_konsumen = pengajuan_berhenti_sewa.id_konsumen')
            ->join('users', 'users.id_user = konsumen.id_user')
            ->join('kost', 'kost.id_kost = pengajuan_berhenti_sewa.id_kost')
            ->join('kamar', 'kamar.id_kamar = pengajuan_berhenti_sewa.id_kamar', 'left')

            // Filter langsung berdasarkan pemilik kost
            ->where('kost.id_pemilik', $idPemilik);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('kost.nama_kost', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status_pengajuan', $status);
        }

        return $builder->paginate($perPage);
    }
}
