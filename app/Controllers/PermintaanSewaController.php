<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Helpers\NotifikasiHelper;
use App\Models\PemesananModel;
use App\Models\KamarModel;
use App\Models\KonsumenModel;
use App\Models\PemilikKostModel;

class PermintaanSewaController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        if ($role == 'admin' || $role == 'pemilik') {
            $title = 'Permintaan Sewa';
        } elseif ($role == 'konsumen') {
            $title = 'Pesanan Saya';
        } else {
            $title = 'Permintaan Sewa';
        }
        return view('pages/permintaan_sewa/index', [
            'title' => $title
        ]);
    }

    public function table()
    {
        $model = new PemesananModel();
        $konsumenModel = new KonsumenModel();
        $pemilikKostModel = new PemilikKostModel();
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);

        $role = session()->get('role');
        $idUser = session()->get('user_id');

        switch ($role) {
            case 'admin':
                $dataPemesanan = $model->getPemesanan($keyword, $status, $perPage);
                break;

            case 'pemilik':
                $pemilik = $pemilikKostModel->where('id_user', $idUser)->first();
                if ($pemilik) {
                    $dataPemesanan = $model->getPemesananByPemilik($pemilik['id_pemilik'], $keyword, $status, $perPage);
                } else {
                    $dataPemesanan = [];
                }
                break;

            case 'konsumen':
                $konsumen = $konsumenModel->where('id_user', $idUser)->first();
                if ($konsumen) {
                    $dataPemesanan = $model->getPemesananByKonsumen($konsumen['id_konsumen'], $keyword, $status, $perPage);
                } else {
                    $dataPemesanan = [];
                }
                break;

            default:
                $dataPemesanan = [];
        }

        $data = [
            'data_pemesanan' => $dataPemesanan,
            'pager'          => $model->pager
        ];

        return view('pages/permintaan_sewa/table', $data);
    }

    public function detail($id)
    {
        $model = new PemesananModel();
        $pemesanan = $model->getDetailPemesanan($id);

        if (!$pemesanan) {
            FlashMessageHelper::setError('Data pemesanan tidak ditemukan.');
            return redirect()->to('dashboard/permintaan-sewa');
        }

        $data = [
            'title' => 'Detail Permintaan Sewa',
            'pemesanan' => $pemesanan
        ];

        return view('pages/permintaan_sewa/detail', $data);
    }

    public function approve($id)
    {
        $model = new PemesananModel();
        $kamarModel = new KamarModel();
        $kostModel = new \App\Models\KostModel();
        $konsumenModel = new KonsumenModel();
        $pemilikKostModel = new PemilikKostModel();
        $pembayaranModel = new \App\Models\PembayaranModel();

        $pemesanan = $model->find($id);

        if (!$pemesanan) {
            FlashMessageHelper::setError('Data pemesanan tidak ditemukan.');
            return redirect()->back();
        }

        $role = session()->get('role');
        $idUser = session()->get('user_id');

        if ($role === 'konsumen') {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk menyetujui permintaan sewa.');
            return redirect()->back();
        } elseif ($role === 'pemilik') {
            $kost = $kostModel->find($pemesanan['id_kost']);
            $pemilik = $pemilikKostModel->where('id_kost', $kost['id_kost'])->first();
            if (!$pemilik || $pemilik['id_user'] != $idUser) {
                FlashMessageHelper::setError('Anda tidak memiliki akses untuk menyetujui permintaan sewa ini.');
                return redirect()->back();
            }
        }
        $db = \Config\Database::connect();
        $db->transStart();
        $model->update($id, ['status_pemesanan' => 'Disetujui']);
        $kamarModel->update($pemesanan['id_kamar'], ['status_ketersediaan' => 'Terisi']);
        $pembayaranModel->insert(['status_pembayaran' => 'Menunggu', 'id_pemesanan' => $id, 'tanggal_pembayaran' => date('Y-m-d')]);
        $db->transComplete();

        if ($db->transStatus() === false) {
            FlashMessageHelper::setError('Gagal menyetujui permintaan sewa.');
            return redirect()->back();
        }

        $notifikasiHelper = new NotifikasiHelper();
        $kost = $kostModel->find($pemesanan['id_kost']);
        $konsumen = $konsumenModel->find($pemesanan['id_konsumen']);

        if ($kost && $konsumen) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($konsumen['id_user']);
            if ($user) {
                $notifikasiHelper->notifikasiStatusPemesanan(
                    $user['id_user'],
                    'Disetujui',
                    $kost['nama_kost']
                );

                $notifikasiHelper->notifikasiAktivitasKost(
                    $kost['id_pemilik'],
                    "Pemesanan dari {$user['nama']} untuk {$kost['nama_kost']} telah disetujui.",
                    'dashboard/permintaan-sewa'
                );
            }
        }

        FlashMessageHelper::setSuccess('Permintaan sewa berhasil disetujui.');
        return redirect()->back();
    }

    public function reject($id)
    {
        $model = new PemesananModel();
        $kostModel = new \App\Models\KostModel();
        $konsumenModel = new KonsumenModel();
        $pemilikKostModel = new PemilikKostModel();
        $pembayaranModel = new \App\Models\PembayaranModel();

        $pemesanan = $model->find($id);

        if (!$pemesanan) {
            FlashMessageHelper::setError('Data pemesanan tidak ditemukan.');
            return redirect()->back();
        }
        $role = session()->get('role');
        $idUser = session()->get('user_id');

        if ($role === 'konsumen') {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk menolak permintaan sewa.');
            return redirect()->back();
        } elseif ($role === 'pemilik') {
            $kost = $kostModel->find($pemesanan['id_kost']);
            $pemilik = $pemilikKostModel->where('id_kost', $kost['id_kost'])->first();
            if (!$pemilik || $pemilik['id_user'] != $idUser) {
                FlashMessageHelper::setError('Anda tidak memiliki akses untuk menolak permintaan sewa ini.');
                return redirect()->back();
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $model->update($id, ['status_pemesanan' => 'Ditolak']);
        $pembayaranModel->insert(['status_pembayaran' => 'Ditolak', 'id_pemesanan' => $id]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            FlashMessageHelper::setError('Gagal menolak permintaan sewa.');
            return redirect()->back();
        }

        $notifikasiHelper = new NotifikasiHelper();
        $kost = $kostModel->find($pemesanan['id_kost']);
        $konsumen = $konsumenModel->find($pemesanan['id_konsumen']);

        if ($kost && $konsumen) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($konsumen['id_user']);
            if ($user) {
                $notifikasiHelper->notifikasiStatusPemesanan(
                    $user['id_user'],
                    'Ditolak',
                    $kost['nama_kost']
                );
            }
        }

        FlashMessageHelper::setSuccess('Permintaan sewa berhasil ditolak.');
        return redirect()->back();
    }
}
