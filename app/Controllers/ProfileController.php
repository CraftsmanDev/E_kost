<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Models\UserModel;
use App\Models\KonsumenModel;
use App\Models\PemilikKostModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard');
        }

        $profileData = [];

        if ($role == 'konsumen') {
            $konsumenModel = new KonsumenModel();
            $konsumen = $konsumenModel->where('id_user', $userId)->first();
            $profileData = $konsumen ?: [];
        } elseif ($role == 'pemilik') {
            $pemilikModel = new PemilikKostModel();
            $pemilik = $pemilikModel->where('id_user', $userId)->first();
            $profileData = $pemilik ?: [];
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
            'profile' => $profileData,
            'role' => $role
        ];

        return view('pages/profile/index', $data);
    }

    public function edit()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard');
        }

        $profileData = [];

        if ($role == 'konsumen') {
            $konsumenModel = new KonsumenModel();
            $konsumen = $konsumenModel->where('id_user', $userId)->first();
            $profileData = $konsumen ?: [];
        } elseif ($role == 'pemilik') {
            $pemilikModel = new PemilikKostModel();
            $pemilik = $pemilikModel->where('id_user', $userId)->first();
            $profileData = $pemilik ?: [];
        }

        $data = [
            'title' => 'Edit Profil',
            'user' => $user,
            'profile' => $profileData,
            'role' => $role
        ];

        return view('pages/profile/edit', $data);
    }

    public function update()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard');
        }

        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'no_hp' => 'required|min_length[10]|max_length[15]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id_user,' . $userId . ']',
            'foto' => [
                'rules' => 'if_exist|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'label' => 'Foto'
            ]
        ];

        if ($this->validate($rules)) {
            $db = \Config\Database::connect();
            $db->transStart();

            $userData = [
                'nama' => $this->request->getPost('nama'),
                'no_hp' => $this->request->getPost('no_hp'),
                'username' => $this->request->getPost('username'),
            ];

            $file = $this->request->getFile('foto');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadDir = FCPATH . 'uploads/profile/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $namaFoto = $file->getRandomName();
                if ($file->move($uploadDir, $namaFoto)) {
                    $userData['foto'] = $namaFoto;
                    if (!empty($user['foto']) && file_exists($uploadDir . $user['foto'])) {
                        unlink($uploadDir . $user['foto']);
                    }
                }
            }

            $userModel->update($userId, $userData);
            session()->set([
                'nama' => $userData['nama'],
                'username' => $userData['username'],
                'no_hp' => $userData['no_hp'],
                'foto' => $userData['foto'] ?? $user['foto']
            ]);

            if ($role == 'konsumen') {
                $konsumenModel = new KonsumenModel();
                $konsumen = $konsumenModel->where('id_user', $userId)->first();

                if ($konsumen) {
                    $konsumenModel->update($konsumen['id_konsumen'], [
                        'alamat' => $this->request->getPost('alamat')
                    ]);
                } else {
                    $konsumenModel->insert([
                        'id_user' => $userId,
                        'alamat' => $this->request->getPost('alamat')
                    ]);
                }
            } elseif ($role == 'pemilik') {
                $pemilikModel = new PemilikKostModel();
                $pemilik = $pemilikModel->where('id_user', $userId)->first();

                if ($pemilik) {
                    $pemilikModel->update($pemilik['id_pemilik'], [
                        'alamat' => $this->request->getPost('alamat'),
                        'nama_bank' => $this->request->getPost('nama_bank'),
                        'nomor_rekening' => $this->request->getPost('nomor_rekening')
                    ]);
                } else {
                    $pemilikModel->insert([
                        'id_user' => $userId,
                        'alamat' => $this->request->getPost('alamat'),
                        'nama_bank' => $this->request->getPost('nama_bank'),
                        'nomor_rekening' => $this->request->getPost('nomor_rekening')
                    ]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                FlashMessageHelper::setError('Gagal mengupdate profil.');
                return redirect()->back()->withInput();
            }

            FlashMessageHelper::setSuccess('Profil berhasil diperbarui.');
            return redirect()->to('dashboard/profile');
        } else {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function change_Password()
    {
        return view('pages/profile/change_password', $data = ['title' => 'ubah password']);
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            FlashMessageHelper::setError('Data pengguna tidak ditemukan.');
            return redirect()->to('dashboard/profile');
        }

        if ($this->request->getMethod() === 'get') {
            $data = [
                'title' => 'Ubah Password'
            ];
            return view('pages/profile/change_password', $data);
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if ($this->validate($rules)) {
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');

            if (!password_verify($currentPassword, $user['password'])) {
                FlashMessageHelper::setError('Password saat ini tidak sesuai.');
                return redirect()->back()->withInput();
            }

            $userModel->update($userId, [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);

            FlashMessageHelper::setSuccess('Password berhasil diubah.');
            return redirect()->to('dashboard/profile');
        } else {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
