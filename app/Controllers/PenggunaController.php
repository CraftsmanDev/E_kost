<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\NotifikasiHelper;
use App\Helpers\FlashMessageHelper;

class PenggunaController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function isAdmin()
    {
        return session()->get('role') === 'admin';
    }

    public function index()
    {
        return view('pages/pengguna/index', [
            'title' => 'Data Pengguna'
        ]);
    }

    public function table()
    {
        $model = new UserModel();

        $keyword = $this->request->getGet('keyword');
        $role    = $this->request->getGet('role');
        $status  = $this->request->getGet('status');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $data = [
            'data_pengguna' => $model->getPengguna($keyword, $role, $status, $perPage),
            'pager'         => $model->pager
        ];

        return view('pages/pengguna/table', $data);
    }

    public function detail($id)
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk melihat detail pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        $pengguna = $this->userModel->find($id);

        if (!$pengguna) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard/pengguna');
        }

        $data = [
            'title' => 'Detail Pengguna',
            'pengguna' => $pengguna
        ];

        return view('pages/pengguna/detail', $data);
    }

    public function tambah()
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk menambah pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        return view('pages/pengguna/tambah', [
            'title' => 'Tambah Pengguna'
        ]);
    }

    public function simpan()
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk menambah pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        $rules = [
            'role_id'  => 'required',
            'nama'     => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required',
            'no_hp'    => 'required',
            'status'   => 'required',
            'foto'     => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $namaFoto = "default.png";
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move(FCPATH . 'assets/', $namaFoto);
        }

        $data = [
            'role_id'  => $this->request->getPost('role_id'),
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'no_hp'    => $this->request->getPost('no_hp'),
            'status'   => $this->request->getPost('status'),
            'foto'     => $namaFoto
        ];

        $model->save($data);
        $id = $model->getInsertID();
        $notifikasiHelper = new NotifikasiHelper();
        $notifikasiHelper->notifikasiPenggunaBaru($id, $this->request->getPost('nama'));

        FlashMessageHelper::setSuccess('Data berhasil ditambahkan.');
        return redirect()->to('/dashboard/pengguna');
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk mengedit pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        $pengguna = $this->userModel->find($id);

        if (!$pengguna) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard/pengguna');
        }

        return view('pages/pengguna/edit', [
            'title' => 'Edit Pengguna',
            'pengguna' => $pengguna
        ]);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk mengupdate pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        $pengguna = $this->userModel->find($id);

        if (!$pengguna) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard/pengguna');
        }

        $rules = [
            'role_id'  => 'required',
            'nama'     => 'required',
            'username' => "required|is_unique[users.username,id_user,{$id}]",
            'no_hp'    => 'required',
            'status'   => 'required',
            'foto'     => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]'
        ];

        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'role_id'  => $this->request->getPost('role_id'),
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'no_hp'    => $this->request->getPost('no_hp'),
            'status'   => $this->request->getPost('status')
        ];

        if ($this->request->getPost('password') != '') {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        // Handle photo upload
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move(FCPATH . 'assets/', $namaFoto);
            $data['foto'] = $namaFoto;
            if (!empty($pengguna['foto']) && $pengguna['foto'] != 'default.png') {
                $oldPhotoPath = FCPATH . 'assets/' . $pengguna['foto'];
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
        }

        $this->userModel->update($id, $data);

        FlashMessageHelper::setSuccess('Data berhasil diubah.');
        return redirect()->to('/dashboard/pengguna');
    }

    public function hapus($id)
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk menghapus pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        $pengguna = $this->userModel->find($id);

        if (!$pengguna) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard/pengguna');
        }

        if ($pengguna['id_user'] == session()->get('user_id')) {
            FlashMessageHelper::setError('Anda tidak dapat menghapus akun sendiri.');
            return redirect()->to('dashboard/pengguna');
        }

        try {
            $this->userModel->delete($id);
            FlashMessageHelper::setSuccess('Data berhasil dihapus.');
        } catch (\Exception $e) {
            FlashMessageHelper::setError('Gagal menghapus data pengguna. Data mungkin terkait dengan data lain.');
        }

        return redirect()->to('dashboard/pengguna');
    }

    public function toggleStatus($id)
    {
        if (!$this->isAdmin()) {
            FlashMessageHelper::setError('Anda tidak memiliki akses untuk mengubah status pengguna.');
            return redirect()->to('dashboard/pengguna');
        }

        $pengguna = $this->userModel->find($id);

        if (!$pengguna) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard/pengguna');
        }
        if ($pengguna['id_user'] == session()->get('user_id')) {
            FlashMessageHelper::setError('Anda tidak dapat mengubah status akun sendiri.');
            return redirect()->to('dashboard/pengguna');
        }

        $newStatus = $pengguna['status'] === 'Aktif' ? 'Nonaktif' : 'Aktif';

        $this->userModel->update($id, ['status' => $newStatus]);

        FlashMessageHelper::setSuccess('Status pengguna berhasil diubah menjadi ' . $newStatus . '.');
        return redirect()->to('dashboard/pengguna');
    }
}
