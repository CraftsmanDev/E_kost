<?php

namespace App\Controllers;

use App\Models\AturanKostModel;
use App\Helpers\FlashMessageHelper;

class AturanKostController extends BaseController
{
    protected $aturanKost;

    public function __construct()
    {
        $this->aturanKost = new AturanKostModel();
    }

    public function index()
    {
        return view('pages/aturan_kost/index', [
            'title' => 'Data Aturan Kost'
        ]);
    }

    public function table()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $data = [
            'data_aturan' => $this->aturanKost->getAturan($keyword, $perPage),
            'pager'       => $this->aturanKost->pager
        ];

        return view('pages/aturan_kost/table', $data);
    }

    public function tambah()
    {
        return view('pages/aturan_kost/tambah', [
            'title' => 'Tambah Aturan Kost'
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama_aturan'     => 'required',
            'deskripsi_aturan' => 'required'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->aturanKost->insert([
            'nama_aturan'      => $this->request->getPost('nama_aturan'),
            'deskripsi_aturan' => $this->request->getPost('deskripsi_aturan')
        ]);

        FlashMessageHelper::setSuccess('Data aturan kost berhasil ditambahkan.');
        return redirect()->to('dashboard/aturan-kost');
    }

    public function edit($id)
    {
        $aturan = $this->aturanKost->find($id);

        if (!$aturan) {
            FlashMessageHelper::setError('Data aturan kost tidak ditemukan.');
            return redirect()->to('dashboard/aturan-kost');
        }

        return view('pages/aturan_kost/edit', [
            'title'  => 'Edit Aturan Kost',
            'aturan' => $aturan
        ]);
    }

    public function update($id)
    {
        $aturan = $this->aturanKost->find($id);

        if (!$aturan) {
            FlashMessageHelper::setError('Data aturan kost tidak ditemukan.');
            return redirect()->to('dashboard/aturan-kost');
        }

        $rules = [
            'nama_aturan'     => 'required',
            'deskripsi_aturan' => 'required'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->aturanKost->update($id, [
            'nama_aturan'      => $this->request->getPost('nama_aturan'),
            'deskripsi_aturan' => $this->request->getPost('deskripsi_aturan')
        ]);

        FlashMessageHelper::setSuccess('Data aturan kost berhasil diupdate.');
        return redirect()->to('dashboard/aturan-kost');
    }

    public function hapus($id)
    {
        $aturan = $this->aturanKost->find($id);

        if (!$aturan) {
            FlashMessageHelper::setError('Data aturan kost tidak ditemukan.');
            return redirect()->to('dashboard/aturan-kost');
        }

        $db = \Config\Database::connect();
        $used = $db->table('detail_aturan_kost')
            ->where('id_aturan', $id)
            ->countAllResults();

        if ($used > 0) {
            FlashMessageHelper::setError('Aturan ini masih digunakan oleh data kost lain dan tidak dapat dihapus.');
            return redirect()->to('dashboard/aturan-kost');
        }

        try {
            $this->aturanKost->delete($id);
            FlashMessageHelper::setSuccess('Data aturan kost berhasil dihapus.');
        } catch (\Exception $e) {
            FlashMessageHelper::setError('Gagal menghapus data aturan kost.');
        }

        return redirect()->to('dashboard/aturan-kost');
    }
}
