<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Helpers\NotifikasiHelper;
use App\Models\KamarModel;
use App\Models\KostModel;
use App\Models\TipeKamarModel;
use App\Models\FasilitasKamarModel;
use App\Models\PemesananModel;
use App\Models\KonsumenModel;
use App\Models\PemilikKostModel;

class KamarController extends BaseController
{
    protected $kamar;
    protected $kost;
    protected $tipe_kamar;
    protected $fasilitas_kamar;

    public function __construct()
    {
        $this->kamar = new KamarModel();
        $this->kost = new KostModel();
        $this->tipe_kamar = new TipeKamarModel();
        $this->fasilitas_kamar = new FasilitasKamarModel();
    }

    public function index($id_kost)
    {
        $kost = $this->kost->find($id_kost);

        if (!$kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kost tidak ditemukan.');
            return redirect()->to('dashboard/kost');
        }

        $kamarTerisi = $this->kamar->where('id_kost', $id_kost)->countAllResults();
        $totalKamar = $kost['total_kamar'];

        $data = [
            'title' => 'Data Kamar',
            'id_kost' => $id_kost,
            'kost' => $kost,
            'kamar_terisi' => $kamarTerisi,
            'total_kamar' => $totalKamar,
            'sisa_slot' => $totalKamar - $kamarTerisi
        ];

        return view('pages/kamar/index', $data);
    }

    public function table($id_kost)
    {
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $data = [
            'data_kamar' => $this->kamar->getKamarByKost($id_kost, $keyword, $status, $perPage),
            'pager' => $this->kamar->pager,
            'id_kost' => $id_kost
        ];

        return view('pages/kamar/table', $data);
    }

    public function stats($id_kost)
    {
        $stats = $this->kamar->getKamarStats($id_kost);
        return $this->response->setJSON($stats);
    }

    public function create($id_kost)
    {
        $kost = $this->kost->find($id_kost);

        if (!$kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kost tidak ditemukan.');
            return redirect()->to('dashboard/kost');
        }

        $kamarTerisi = $this->kamar->where('id_kost', $id_kost)->countAllResults();
        $totalKamar = $kost['total_kamar'];
        $sisaSlot = $totalKamar - $kamarTerisi;

        $data = [
            'title' => 'Tambah Kamar',
            'id_kost' => $id_kost,
            'kost' => $kost,
            'tipe_kamar' => $this->tipe_kamar->findAll(),
            'fasilitas_kamar' => $this->fasilitas_kamar->findAll(),
            'kamar_terisi' => $kamarTerisi,
            'total_kamar' => $totalKamar,
            'sisa_slot' => $sisaSlot
        ];

        return view('pages/kamar/create', $data);
    }

    public function store($id_kost)
    {
        $rules = [
            'nomor_kamar' => 'required',
            'harga_sewa' => 'required|numeric',
            'id_tipe_kamar' => 'required',
            'id_fasilitas_kamar' => 'required',
            'status_ketersediaan' => 'required'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setFlashMessage('error', 'Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $kost = $this->kost->find($id_kost);

        if (!$kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kost tidak ditemukan.');
            return redirect()->to('dashboard/kost');
        }

        $kamarTerisi = $this->kamar->where('id_kost', $id_kost)->countAllResults();
        if ($kamarTerisi >= $kost['total_kamar']) {
            FlashMessageHelper::setFlashMessage('error', 'Jumlah kamar sudah mencapai batas maksimal (' . $kost['total_kamar'] . ' kamar). Tidak dapat menambah kamar lagi.');
            return redirect()->to(base_url('dashboard/kamar/' . $id_kost . '/create'));
        }

        try {
            $this->kamar->insert([
                'id_kost' => $id_kost,
                'nomor_kamar' => $this->request->getPost('nomor_kamar'),
                'harga_sewa' => $this->request->getPost('harga_sewa'),
                'id_tipe_kamar' => $this->request->getPost('id_tipe_kamar'),
                'id_fasilitas_kamar' => $this->request->getPost('id_fasilitas_kamar'),
                'status_ketersediaan' => $this->request->getPost('status_ketersediaan')
            ]);

            FlashMessageHelper::setFlashMessage('success', 'Data kamar berhasil ditambahkan.');
            return redirect()->to(base_url('dashboard/kamar/' . $id_kost));
        } catch (\Throwable $e) {
            FlashMessageHelper::setFlashMessage('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id_kost, $id_kamar)
    {
        $kost = $this->kost->find($id_kost);
        $kamar = $this->kamar->find($id_kamar);

        if (!$kost || !$kamar) {
            FlashMessageHelper::setFlashMessage('error', 'Data tidak ditemukan.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        if ($kamar['id_kost'] != $id_kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar tidak sesuai dengan kost yang dipilih.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        $data = [
            'title' => 'Edit Kamar',
            'id_kost' => $id_kost,
            'id_kamar' => $id_kamar,
            'kost' => $kost,
            'kamar' => $kamar,
            'tipe_kamar' => $this->tipe_kamar->findAll(),
            'fasilitas_kamar' => $this->fasilitas_kamar->findAll()
        ];

        return view('pages/kamar/edit', $data);
    }

    public function update($id_kost, $id_kamar)
    {
        $rules = [
            'nomor_kamar' => 'required',
            'harga_sewa' => 'required|numeric',
            'id_tipe_kamar' => 'required',
            'id_fasilitas_kamar' => 'required',
            'status_ketersediaan' => 'required'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setFlashMessage('error', 'Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $kamar = $this->kamar->find($id_kamar);

        if (!$kamar) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar tidak ditemukan.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        if ($kamar['id_kost'] != $id_kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar tidak sesuai dengan kost yang dipilih.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        try {
            $this->kamar->update($id_kamar, [
                'nomor_kamar' => $this->request->getPost('nomor_kamar'),
                'harga_sewa' => $this->request->getPost('harga_sewa'),
                'id_tipe_kamar' => $this->request->getPost('id_tipe_kamar'),
                'id_fasilitas_kamar' => $this->request->getPost('id_fasilitas_kamar'),
                'status_ketersediaan' => $this->request->getPost('status_ketersediaan')
            ]);

            FlashMessageHelper::setFlashMessage('success', 'Data kamar berhasil diupdate.');
            return redirect()->to(base_url('dashboard/kamar/' . $id_kost));
        } catch (\Throwable $e) {
            FlashMessageHelper::setFlashMessage('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($id_kost, $id_kamar)
    {
        $kamar = $this->kamar->find($id_kamar);

        if (!$kamar) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar tidak ditemukan.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        if ($kamar['id_kost'] != $id_kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar tidak sesuai dengan kost yang dipilih.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        try {
            $this->kamar->delete($id_kamar);
            FlashMessageHelper::setFlashMessage('success', 'Data kamar berhasil dihapus.');
            return redirect()->to(base_url('dashboard/kamar/' . $id_kost));
        } catch (\Throwable $e) {
            FlashMessageHelper::setFlashMessage('error', 'Gagal menghapus data kamar.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }
    }

    public function pesan($id_kost, $id_kamar)
    {
        $kamar = $this->kamar->find($id_kamar);
        $kost = $this->kost->find($id_kost);

        if (!$kamar || !$kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar atau kost tidak ditemukan.');
            return redirect()->to('dashboard/kost');
        }

        if ($kamar['id_kost'] != $id_kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kamar tidak sesuai dengan kost yang dipilih.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        if ($kamar['status_ketersediaan'] != 'Tersedia') {
            FlashMessageHelper::setFlashMessage('error', 'Kamar tidak tersedia untuk dipesan.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }

        $userId = session()->get('user_id');
        $namaUser = session()->get('nama');
        $konsumenModel = new KonsumenModel();
        $konsumen = $konsumenModel->where('id_user', $userId)->first();

        if (!$konsumen) {
            FlashMessageHelper::setFlashMessage('error', 'Data konsumen tidak ditemukan.');
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }
        $pemesananModel = new PemesananModel();
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $idPemesanan = $pemesananModel->insert([
                'id_konsumen' => $konsumen['id_konsumen'],
                'id_kost' => $id_kost,
                'id_kamar' => $id_kamar,
                'tanggal_pemesanan' => date('Y-m-d'),
                'status_pemesanan' => 'Menunggu'
            ]);
            $this->kamar->update($id_kamar, ['status_ketersediaan' => 'Dipesan']);
            $db->transComplete();
            if ($db->transStatus() === false) {
                FlashMessageHelper::setFlashMessage('error', 'Gagal melakukan pemesanan kamar.');
                return redirect()->to('dashboard/kamar/' . $id_kost);
            }
            $notifikasiHelper = new NotifikasiHelper();
            $notifikasiHelper->notifikasiPemesananBaruAdmin(
                $idPemesanan,
                $namaUser,
                $kost['nama_kost']
            );

            $pemilikKostModel = new PemilikKostModel();
            if (!empty($kost['id_pemilik'])) {
                $notifikasiHelper->notifikasiPemesananBaruPemilik(
                    $kost['id_pemilik'],
                    $idPemesanan,
                    $namaUser,
                    $kost['nama_kost']
                );
            }

            FlashMessageHelper::setFlashMessage('success', 'Pemesanan kamar berhasil. Silakan lakukan pembayaran.');
            return redirect()->to('dashboard/permintaan-sewa');
        } catch (\Throwable $e) {
            $db->transRollback();
            FlashMessageHelper::setFlashMessage('error', 'Gagal melakukan pemesanan: ' . $e->getMessage());
            return redirect()->to('dashboard/kamar/' . $id_kost);
        }
    }
}
