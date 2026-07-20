<?php

namespace App\Helpers;

use App\Models\NotifikasiModel;

class NotifikasiHelper
{
    protected $notifikasiModel;

    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
    }

    // Admin notifications
    public function notifikasiPenggunaBaru($idUser, $nama)
    {
        $data = [
            'id_user' => null,
            'role' => 'admin',
            'judul' => 'Pengguna Baru Terdaftar',
            'pesan' => "Pengguna baru '$nama' telah mendaftar di sistem.",
            'tipe' => 'user',
            'link' => 'dashboard/pengguna',
            'data_terkait' => json_encode(['id_user' => $idUser, 'nama' => $nama])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiPemesananBaruAdmin($idPemesanan, $namaKonsumen, $namaKost)
    {
        $data = [
            'id_user' => null,
            'role' => 'admin',
            'judul' => 'Pemesanan Baru',
            'pesan' => "$namaKonsumen telah melakukan pemesanan di $namaKost.",
            'tipe' => 'booking',
            'link' => 'dashboard/permintaan-sewa',
            'data_terkait' => json_encode(['id_pemesanan' => $idPemesanan])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiPembayaranMenunggu($idPembayaran, $namaKonsumen)
    {
        $data = [
            'id_user' => null,
            'role' => 'admin',
            'judul' => 'Pembayaran Menunggu Verifikasi',
            'pesan' => "Pembayaran dari $namaKonsumen menunggu verifikasi.",
            'tipe' => 'payment',
            'link' => 'dashboard/pembayaran',
            'data_terkait' => json_encode(['id_pembayaran' => $idPembayaran])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiLaporanSistem($pesan)
    {
        $data = [
            'id_user' => null,
            'role' => 'admin',
            'judul' => 'Laporan Sistem',
            'pesan' => $pesan,
            'tipe' => 'system',
            'link' => 'dashboard',
            'data_terkait' => null
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiPemesananBaruPemilik($idPemilik, $idPemesanan, $namaKonsumen, $namaKost)
    {
        $data = [
            'id_user' => null,
            'role' => 'pemilik',
            'id_pemilik' => $idPemilik,
            'judul' => 'Pemesanan Baru',
            'pesan' => "$namaKonsumen telah melakukan pemesanan di $namaKost.",
            'tipe' => 'booking',
            'link' => 'dashboard/permintaan-sewa',
            'data_terkait' => json_encode(['id_pemesanan' => $idPemesanan])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiPembayaranDiunggah($idPemilik, $idPembayaran, $namaKonsumen, $namaKost)
    {
        $data = [
            'id_user' => null,
            'role' => 'pemilik',
            'id_pemilik' => $idPemilik,
            'judul' => 'Pembayaran Diunggah',
            'pesan' => "$namaKonsumen telah mengunggah bukti pembayaran untuk $namaKost.",
            'tipe' => 'payment',
            'link' => 'dashboard/pembayaran',
            'data_terkait' => json_encode(['id_pembayaran' => $idPembayaran])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiPenghuniBaru($idPemilik, $namaKonsumen, $namaKost, $nomorKamar)
    {
        $data = [
            'id_user' => null,
            'role' => 'pemilik',
            'id_pemilik' => $idPemilik,
            'judul' => 'Penghuni Baru',
            'pesan' => "$namaKonsumen telah menjadi penghuni kamar $nomorKamar di $namaKost.",
            'tipe' => 'tenant',
            'link' => 'dashboard/penghuni',
            'data_terkait' => null
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiAktivitasKost($idPemilik, $pesan, $link = null)
    {
        $data = [
            'id_user' => null,
            'role' => 'pemilik',
            'id_pemilik' => $idPemilik,
            'judul' => 'Aktivitas Kost',
            'pesan' => $pesan,
            'tipe' => 'activity',
            'link' => $link ?: 'dashboard',
            'data_terkait' => null
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    // Konsumen notifications
    public function notifikasiStatusPemesanan($idUser, $status, $namaKost)
    {
        $judul = match($status) {
            'Disetujui' => 'Pemesanan Disetujui',
            'Ditolak' => 'Pemesanan Ditolak',
            'Selesai' => 'Pemesanan Selesai',
            default => 'Status Pemesanan Berubah'
        };

        $data = [
            'id_user' => $idUser,
            'role' => 'konsumen',
            'judul' => $judul,
            'pesan' => "Status pemesanan Anda di $namaKost telah berubah menjadi $status.",
            'tipe' => 'booking',
            'link' => 'dashboard/permintaan-sewa',
            'data_terkait' => json_encode(['status' => $status])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiVerifikasiPembayaran($idUser, $status, $namaKost)
    {
        $judul = match($status) {
            'Disetujui' => 'Pembayaran Disetujui',
            'Ditolak' => 'Pembayaran Ditolak',
            'Menunggu' => 'Pembayaran Menunggu Verifikasi',
            default => 'Status Pembayaran Berubah'
        };

        $data = [
            'id_user' => $idUser,
            'role' => 'konsumen',
            'judul' => $judul,
            'pesan' => "Status pembayaran Anda untuk $namaKost telah berubah menjadi $status.",
            'tipe' => 'payment',
            'link' => 'dashboard/pembayaran',
            'data_terkait' => json_encode(['status' => $status])
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiKonfirmasiPenyewaan($idUser, $namaKost, $nomorKamar)
    {
        $data = [
            'id_user' => $idUser,
            'role' => 'konsumen',
            'judul' => 'Konfirmasi Penyewaan',
            'pesan' => "Selamat! Anda telah resmi menjadi penghuni kamar $nomorKamar di $namaKost.",
            'tipe' => 'success',
            'link' => 'dashboard/penghuni',
            'data_terkait' => null
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiInformasiPenting($idUser, $judul, $pesan, $link = null)
    {
        $data = [
            'id_user' => $idUser,
            'role' => 'konsumen',
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => 'info',
            'link' => $link ?: 'dashboard',
            'data_terkait' => null
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }

    public function notifikasiUmum($idUser, $role, $judul, $pesan, $tipe = 'info', $link = null, $idPemilik = null)
    {
        $data = [
            'id_user' => $idUser,
            'role' => $role,
            'id_pemilik' => $idPemilik,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
            'link' => $link ?: 'dashboard',
            'data_terkait' => null
        ];

        return $this->notifikasiModel->createNotifikasi($data);
    }
}
