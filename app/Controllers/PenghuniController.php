<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Models\PenghuniModel;
use App\Models\PemesananModel;
use App\Models\KamarModel;
use App\Models\KonsumenModel;
use App\Models\PemilikKostModel;

class PenghuniController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        if ($role == 'admin' || $role == 'pemilik') {
            $title = 'Data Penghuni';
            $subtitle = 'Daftar penghuni kost';
        } elseif ($role == 'konsumen') {
            $title = 'Sewa Saya';
            $subtitle = 'Daftar Sewa Saya';
        } else {
            $title = 'Data Penghuni';
        }
        return view('pages/penghuni/index', [
            'title' => $title,
            'subtitle' => $subtitle
        ]);
    }

    public function table()
    {
        $model = new PenghuniModel();
        $konsumenModel = new KonsumenModel();
        $pemilikKostModel = new PemilikKostModel();

        $keyword = $this->request->getGet('keyword');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $role = session()->get('role');
        $idUser = session()->get('user_id');

        switch ($role) {
            case 'admin':
                $dataPenghuni = $model->getPenghuni($keyword, $perPage);
                break;

            case 'pemilik':
                $pemilik = $pemilikKostModel->where('id_user', $idUser)->first();
                if ($pemilik) {
                    $dataPenghuni = $model->getPenghuniByPemilik($pemilik['id_pemilik'], $keyword, $perPage);
                } else {
                    $dataPenghuni = [];
                }
                break;

            case 'konsumen':
                $konsumen = $konsumenModel->where('id_user', $idUser)->first();
                if ($konsumen) {
                    $dataPenghuni = $model->getPenghuniByKonsumen($konsumen['id_konsumen'], $keyword, $perPage);
                } else {
                    $dataPenghuni = [];
                }
                break;

            default:
                $dataPenghuni = [];
        }

        $data = [
            'data_penghuni' => $dataPenghuni,
            'pager' => $model->pager
        ];

        return view('pages/penghuni/table', $data);
    }

    public function detail($id)
    {
        $model = new PenghuniModel();
        $penghuni = $model->getPenghuniDetail($id);

        if (!$penghuni) {
            FlashMessageHelper::setError('Data penghuni tidak ditemukan.');
            return redirect()->to('dashboard/penghuni');
        }

        $data = [
            'title' => 'Detail Penghuni',
            'penghuni' => $penghuni,
            'role' => session()->get('role')
        ];

        return view('pages/penghuni/detail', $data);
    }

    public function edit($id)
    {
        $role = session()->get('role');
        if ($role != 'admin') {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk mengedit status penghuni.');
            return redirect()->to('dashboard/penghuni');
        }

        $model = new PenghuniModel();
        $penghuni = $model->getPenghuniDetail($id);

        if (!$penghuni) {
            FlashMessageHelper::setError('Data penghuni tidak ditemukan.');
            return redirect()->to('dashboard/penghuni');
        }

        $data = [
            'title' => 'Edit Penghuni',
            'penghuni' => $penghuni
        ];

        return view('pages/penghuni/edit', $data);
    }

    public function update($id)
    {
        $role = session()->get('role');

        // Only admin can update status
        if ($role != 'admin') {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk mengubah status penghuni.');
            return redirect()->to('dashboard/penghuni');
        }

        $model = new PenghuniModel();
        $penghuni = $model->getPenghuniDetail($id);

        if (!$penghuni) {
            FlashMessageHelper::setError('Data penghuni tidak ditemukan.');
            return redirect()->to('dashboard/penghuni');
        }

        $data = [
            'status_pemesanan' => $this->request->getPost('status_pemesanan')
        ];

        $model->update($id, $data);

        FlashMessageHelper::setSuccess('Data penghuni berhasil diupdate.');
        return redirect()->to('dashboard/penghuni');
    }

    public function delete($id)
    {
        $role = session()->get('role');

        // Only admin can delete tenant data
        if ($role != 'admin') {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk menghapus data penghuni.');
            return redirect()->to('dashboard/penghuni');
        }

        $model = new PenghuniModel();
        $penghuni = $model->getPenghuniDetail($id);

        if (!$penghuni) {
            FlashMessageHelper::setError('Data penghuni tidak ditemukan.');
            return redirect()->to('dashboard/penghuni');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Update room availability to available
        if (!empty($penghuni['id_kamar'])) {
            $kamarModel = new KamarModel();
            $kamarModel->update($penghuni['id_kamar'], ['status_ketersediaan' => 'Tersedia']);
        }

        // Update booking status
        if (!empty($penghuni['id_pemesanan'])) {
            $pemesananModel = new PemesananModel();
            $pemesananModel->update($penghuni['id_pemesanan'], ['status_pemesanan' => 'Selesai']);
        }

        $model->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) {
            FlashMessageHelper::setError('Gagal menghapus data penghuni.');
            return redirect()->to('dashboard/penghuni');
        }

        FlashMessageHelper::setSuccess('Data penghuni berhasil dihapus.');
        return redirect()->to('dashboard/penghuni');
    }
}
