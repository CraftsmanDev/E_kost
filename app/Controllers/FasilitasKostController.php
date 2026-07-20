<?php

namespace App\Controllers;

use App\Models\FasilitasKostModel;
use App\Helpers\FlashMessageHelper;

class FasilitasKostController extends BaseController
{
    protected $fasilitasKost;

    public function __construct()
    {
        $this->fasilitasKost = new FasilitasKostModel();
    }

    public function index()
    {
        return view('pages/fasilitas_kost/index', [
            'title' => 'Data Fasilitas Kost'
        ]);
    }

    public function table()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $data = [
            'data_fasilitas' => $this->fasilitasKost->getFasilitas($keyword, $perPage),
            'pager'          => $this->fasilitasKost->pager
        ];

        return view('pages/fasilitas_kost/table', $data);
    }

    public function tambah()
    {
        return view('pages/fasilitas_kost/tambah', [
            'title' => 'Tambah Fasilitas Kost'
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama_fasilitas' => 'required',
            'deskripsi'      => 'required'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->fasilitasKost->insert([
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'deskripsi'      => $this->request->getPost('deskripsi')
        ]);

        FlashMessageHelper::setSuccess('Data fasilitas kost berhasil ditambahkan.');
        return redirect()->to('dashboard/fasilitas-kost');
    }

    public function edit($id)
    {
        $fasilitas = $this->fasilitasKost->find($id);

        if (!$fasilitas) {
            FlashMessageHelper::setError('Data fasilitas kost tidak ditemukan.');
            return redirect()->to('dashboard/fasilitas-kost');
        }

        return view('pages/fasilitas_kost/edit', [
            'title'     => 'Edit Fasilitas Kost',
            'fasilitas' => $fasilitas
        ]);
    }

    public function update($id)
    {
        $fasilitas = $this->fasilitasKost->find($id);

        if (!$fasilitas) {
            FlashMessageHelper::setError('Data fasilitas kost tidak ditemukan.');
            return redirect()->to('dashboard/fasilitas-kost');
        }

        $rules = [
            'nama_fasilitas' => 'required',
            'deskripsi'      => 'required'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->fasilitasKost->update($id, [
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'deskripsi'      => $this->request->getPost('deskripsi')
        ]);

        FlashMessageHelper::setSuccess('Data fasilitas kost berhasil diupdate.');
        return redirect()->to('dashboard/fasilitas-kost');
    }

    public function hapus($id)
    {
        $fasilitas = $this->fasilitasKost->find($id);

        if (!$fasilitas) {
            FlashMessageHelper::setError('Data fasilitas kost tidak ditemukan.');
            return redirect()->to('dashboard/fasilitas-kost');
        }

        $db = \Config\Database::connect();
        $used = $db->table('detail_fasilitas_kost')
            ->where('id_fasilitas_kost', $id)
            ->countAllResults();

        if ($used > 0) {
            FlashMessageHelper::setError('Fasilitas ini masih digunakan oleh data kost lain dan tidak dapat dihapus.');
            return redirect()->to('dashboard/fasilitas-kost');
        }

        try {
            $this->fasilitasKost->delete($id);
            FlashMessageHelper::setSuccess('Data fasilitas kost berhasil dihapus.');
        } catch (\Exception $e) {
            FlashMessageHelper::setError('Gagal menghapus data fasilitas kost.');
        }

        return redirect()->to('dashboard/fasilitas-kost');
    }
}
