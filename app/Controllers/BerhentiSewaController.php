<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Models\PengajuanBerhentiModel;
use App\Models\PenghuniModel;
use App\Models\KamarModel;
use App\Models\PemesananModel;
use App\Models\KonsumenModel;
use App\Models\PemilikKostModel;
use App\Models\KostModel;

class BerhentiSewaController extends BaseController
{
    public function index()
    {
        return view('pages/berhenti-sewa/index', [
            'title' => 'Berhenti Sewa'
        ]);
    }

    public function table()
    {
        $model = new PengajuanBerhentiModel();
        $konsumenModel = new KonsumenModel();
        $pemilikKostModel = new PemilikKostModel();

        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $role = session()->get('role');
        $idUser = session()->get('user_id');
        switch ($role) {
            case 'admin':
                $dataPengajuan = $model->getPengajuan($keyword, $status, $perPage);
                break;

            case 'pemilik':
                $pemilik = $pemilikKostModel->where('id_user', $idUser)->first();
                if ($pemilik) {
                    $dataPengajuan = $model->getPengajuanByPemilik($pemilik['id_pemilik'], $keyword, $status, $perPage);
                } else {
                    $dataPengajuan = [];
                }
                break;

            case 'konsumen':
                $konsumen = $konsumenModel->where('id_user', $idUser)->first();
                if ($konsumen) {
                    $dataPengajuan = $model->getPengajuanByKonsumen($konsumen['id_konsumen'], $keyword, $status, $perPage);
                } else {
                    $dataPengajuan = [];
                }
                break;

            default:
                $dataPengajuan = [];
        }
        $data = [
            'data_pengajuan' => $dataPengajuan,
            'pager' => $model->pager
        ];

        return view('pages/berhenti-sewa/table', $data);
    }

    public function detail($id)
    {
        $model = new PengajuanBerhentiModel();
        $pengajuan = $model->getDetailPengajuan($id);

        if (!$pengajuan) {
            FlashMessageHelper::setError('Data pengajuan tidak ditemukan.');
            return redirect()->to('dashboard/pengajuan-berhenti');
        }

        $data = [
            'title' => 'Detail Pengajuan Berhenti Sewa',
            'pengajuan' => $pengajuan
        ];

        return view('pages/berhenti-sewa/detail', $data);
    }

    public function exit($id)
    {
        $pemesananModel = new PemesananModel();
        $kostModel = new KostModel();
        $kamarModel = new KamarModel();
        $pemesanan = $pemesananModel->find($id);
        if (!$pemesanan) {
            return redirect()->back()->with('error', 'Data pemesanan tidak ditemukan.');
        }
        $kost = $kostModel->find($pemesanan['id_kost']);
        $kamar = $kamarModel->find($pemesanan['id_kamar']);
        return view('pages/penghuni/berhenti_sewa', [
            'title' => 'Pengajuan Berhenti Sewa',
            'pemesanan' => $pemesanan,
            'kost' => $kost,
            'kamar' => $kamar
        ]);
    }

    public function storeExit($id)
    {
        $pemesananModel = new PemesananModel();
        $pengajuanModel = new PengajuanBerhentiModel();
        $pemesanan = $pemesananModel->find($id);
        if (!$pemesanan) {
            FlashMessageHelper::setFlashMessage('error', 'Data pemesanan tidak ditemukan.');
            return redirect()->back();
        }

        $pengajuanModel->insert([
            'id_pemesanan'       => $pemesanan['id_pemesanan'],
            'id_konsumen'        => $pemesanan['id_konsumen'],
            'id_kost'            => $pemesanan['id_kost'],
            'id_kamar'           => $pemesanan['id_kamar'],
            'tanggal_pengajuan'  => date('Y-m-d'),
            'tanggal_berhenti'   => $this->request->getPost('tanggal_berhenti'),
            'alasan'             => $this->request->getPost('alasan'),
            'status_pengajuan'   => 'Menunggu',
            'catatan_admin'      => null
        ]);

        FlashMessageHelper::setFlashMessage('success', 'Pengajuan berhenti sewa berhasil dikirim.');
        return redirect()->to('dashboard/permintaan-sewa');
    }

    public function approve($id)
    {
        $model = new PengajuanBerhentiModel();
        $penghuniModel = new PenghuniModel();
        $kamarModel = new KamarModel();
        $pemesananModel = new PemesananModel();

        $pengajuan = $model->find($id);

        if (!$pengajuan) {
            FlashMessageHelper::setFlashMessage('error', 'Data pengajuan tidak ditemukan.');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $model->update($id, [
            'status_pengajuan' => 'Disetujui'
        ]);

        $kamarModel->update($pengajuan['id_kamar'], [
            'status_ketersediaan' => 'Tersedia'
        ]);

        $pemesananModel->update($pengajuan['id_pemesanan'], [
            'status_pemesanan' => 'Berhenti Sewa'
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            FlashMessageHelper::setError('Gagal menyetujui pengajuan.');
            return redirect()->back();
        }

        FlashMessageHelper::setSuccess('Pengajuan berhasil disetujui.');
        return redirect()->back();
    }

    public function reject($id)
    {
        $model = new PengajuanBerhentiModel();

        $pengajuan = $model->find($id);

        if (!$pengajuan) {
            FlashMessageHelper::setError('Data pengajuan tidak ditemukan.');
            return redirect()->back();
        }

        $model->update($id, [
            'status_pengajuan' => 'Ditolak'
        ]);

        FlashMessageHelper::setSuccess('Pengajuan berhenti sewa berhasil ditolak.');
        return redirect()->back();
    }
}
