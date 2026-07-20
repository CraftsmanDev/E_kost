<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Helpers\NotifikasiHelper;
use App\Models\PembayaranModel;
use App\Models\PemesananModel;
use App\Models\PenghuniModel;
use App\Models\KonsumenModel;
use App\Models\KostModel;
use App\Models\PemilikKostModel;

class PembayaranController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        $title = match($role) {
            'admin' => 'Verifikasi Pembayaran',
            'pemilik' => 'Verifikasi Pembayaran',
            'konsumen' => 'Pembayaran Saya',
            default => 'Pembayaran'
        };

        return view('pages/pembayaran/index', [
            'title' => $title,
            'current_role' => $role
        ]);
    }

    public function table()
    {
        $model = new PembayaranModel();
        $konsumenModel = new KonsumenModel();
        $pemilikKostModel = new PemilikKostModel();

        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');
        $bulan   = $this->request->getGet('bulan');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $role   = session()->get('role');
        $idUser = session()->get('user_id');

        switch ($role) {
            case 'admin':
                $dataPembayaran = $model->getPembayaran(
                    $keyword,
                    $status,
                    $bulan,
                    null,
                    $perPage
                );
                break;

            case 'pemilik':
                $pemilik = $pemilikKostModel
                    ->where('id_user', $idUser)
                    ->first();
                if ($pemilik) {
                    $dataPembayaran = $model->getPembayaranByPemilik(
                        $pemilik['id_pemilik'],
                        $keyword,
                        $status,
                        $bulan,
                        $perPage
                    );
                } else {
                    $dataPembayaran = [];
                }
                break;

            case 'konsumen':
                $konsumen = $konsumenModel
                    ->where('id_user', $idUser)
                    ->first();
                if ($konsumen) {
                    $dataPembayaran = $model->getPembayaranByKonsumen(
                        $konsumen['id_konsumen'],
                        $keyword,
                        $status,
                        $bulan,
                        $perPage
                    );
                } else {
                    $dataPembayaran = [];
                }
                break;
            default:
                $dataPembayaran = [];
        }

        // \dd($dataPembayaran);

        return view('pages/pembayaran/table', [
            'data_pembayaran' => $dataPembayaran,
            'pager'           => $model->pager,
            'current_role'    => $role,
            'keyword'         => $keyword,
            'status'          => $status,
            'bulan'           => $bulan
        ]);
    }

    public function detail($id)
    {
        $model = new PembayaranModel();
        $pembayaran = $model->getDetailPembayaran($id);

        if (!$pembayaran) {
            FlashMessageHelper::setFlashMessage('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->to('dashboard/pembayaran');
        }

        $data = [
            'title' => 'Detail Pembayaran',
            'pembayaran' => $pembayaran
        ];

        return view('pages/pembayaran/detail', $data);
    }

    public function approve($id)
    {
        $model = new PembayaranModel();
        $pemesananModel = new PemesananModel();
        $kostModel = new KostModel();
        $konsumenModel = new KonsumenModel();
        $userModel = new \App\Models\UserModel();
        $pembayaran = $model->find($id);
        if (!$pembayaran) {
            FlashMessageHelper::setFlashMessage('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->back();
        }
        $db = \Config\Database::connect();
        $db->transStart();
        $model->update($id, [
            'status_pembayaran' => 'Disetujui'
        ]);
        $pemesananModel->update($pembayaran['id_pemesanan'], [
            'status_pemesanan' => 'Disetujui'
        ]);
        $db->transComplete();
        if (!$db->transStatus()) {
            FlashMessageHelper::setFlashMessage('error', 'Gagal menyetujui pembayaran.');
            return redirect()->back();
        }
        $notifikasiHelper = new NotifikasiHelper();
        $pemesanan = $pemesananModel->find($pembayaran['id_pemesanan']);
        if ($pemesanan) {
            $kost = $kostModel->find($pemesanan['id_kost']);
            $konsumen = $konsumenModel->find($pemesanan['id_konsumen']);
            $kamar = (new \App\Models\KamarModel())->find($pemesanan['id_kamar']);
            if ($kost && $konsumen && $kamar) {
                $user = $userModel->find($konsumen['id_user']);
                if ($user) {
                    $notifikasiHelper->notifikasiVerifikasiPembayaran(
                        $user['id_user'],
                        'Disetujui',
                        $kost['nama_kost']
                    );

                    $notifikasiHelper->notifikasiKonfirmasiPenyewaan(
                        $user['id_user'],
                        $kost['nama_kost'],
                        $kamar['nomor_kamar']
                    );
                }

                $notifikasiHelper->notifikasiPenghuniBaru(
                    $user['id_user'],
                    $kost['id_pemilik'],
                    $user['nama'],
                    $kost['nama_kost'],
                    $kamar['nomor_kamar']
                );
            }
        }

        FlashMessageHelper::setFlashMessage('success', 'Pembayaran berhasil disetujui.');

        return redirect()->back();
    }

    public function reject($id)
    {
        $model = new PembayaranModel();
        $pemesananModel = new PemesananModel();
        $kostModel = new KostModel();
        $konsumenModel = new KonsumenModel();
        $userModel = new \App\Models\UserModel();
        $pembayaran = $model->find($id);
        if (!$pembayaran) {
            FlashMessageHelper::setFlashMessage('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->back();
        }
        $db = \Config\Database::connect();
        $db->transStart();
        $model->update($id, [
            'status_pembayaran' => 'Ditolak'
        ]);
        $pemesananModel->update($pembayaran['id_pemesanan'], [
            'status_pemesanan' => 'Ditolak'
        ]);
        $db->transComplete();
        if (!$db->transStatus()) {
            FlashMessageHelper::setFlashMessage('error', 'Gagal menolak pembayaran.');
            return redirect()->back();
        }
        $notifikasiHelper = new NotifikasiHelper();
        $pemesanan = $pemesananModel->find($pembayaran['id_pemesanan']);
        if ($pemesanan) {
            $kost = $kostModel->find($pemesanan['id_kost']);
            $konsumen = $konsumenModel->find($pemesanan['id_konsumen']);
            if ($kost && $konsumen) {
                $user = $userModel->find($konsumen['id_user']);
                if ($user) {
                    $notifikasiHelper->notifikasiVerifikasiPembayaran(
                        $user['id_user'],
                        'Ditolak',
                        $kost['nama_kost']
                    );
                }
            }
        }
        FlashMessageHelper::setFlashMessage('success', 'Pembayaran berhasil ditolak.');
        return redirect()->back();
    }

    public function uploadBukti($id)
    {
        $model = new PembayaranModel();
        $idpembayaran = $model->where('id_pemesanan', $id)->first();
        $pembayaran = $model->find($idpembayaran['id_pembayaran']);
        if (!$pembayaran) {
            FlashMessageHelper::setFlashMessage('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->back();
        }
        $file = $this->request->getFile('bukti_pembayaran');
        if (!$file->isValid()) {
            FlashMessageHelper::setFlashMessage('error', 'Silakan pilih file bukti pembayaran.');
            return redirect()->back();
        }
        $namaBukti = $file->getRandomName();
        $file->move(FCPATH . 'uploads/bukti/', $namaBukti);

        $updateData = [
            'bukti_pembayaran' => $namaBukti,
            'tanggal_pembayaran' => date('Y-m-d'),
        ];

        $jumlahPembayaran = $this->request->getPost('jumlah_pembayaran');
        if (!empty($jumlahPembayaran) && is_numeric($jumlahPembayaran)) {
            $updateData['jumlah_pembayaran'] = (int) $jumlahPembayaran;
        }

        $model->update($pembayaran['id_pembayaran'], $updateData);

        FlashMessageHelper::setFlashMessage('success', 'Bukti pembayaran berhasil diunggah.');
        return redirect()->to('dashboard/pembayaran');
    }

    public function formUpload($id)
    {
        $model = new PembayaranModel();
        $pembayaran = $model->getDetailPembayaran($id);
        $data = [
            'title' => 'Upload Bukti Pembayaran',
            'pembayaran' => $pembayaran
        ];

        return view('pages/pembayaran/upload_bukti', $data);
    }
}
