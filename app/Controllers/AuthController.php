<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\KonsumenModel;
use App\Models\PemilikKostModel;
use App\Helpers\NotifikasiHelper;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login', $data = ['title' => 'Login']);
    }

    public function register()
    {
        return view('auth/registrasi', $data = ['title' => 'Registrasi']);
    }

    public function store()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $userModel = new UserModel();
        $RoleModel = new RoleModel();
        $user = $userModel
            ->where('username', $username)
            ->first();
        if (!$user) {
            return redirect()->back()->with(
                'error',
                'Username atau Password salah'
            );
        }
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with(
                'error',
                'Username atau Password salah'
            );
        }
        if ($user['status'] !== 'Aktif') {
            return redirect()->back()->with(
                'error',
                'Akun Anda belum diverifikasi oleh admin.'
            );
        }
        $role = $RoleModel->find($user['role_id']);
        session()->set([
            'user_id'      => $user['id_user'],
            'username'     => $user['username'],
            'nama'         => $user['nama'],
            'role'         => $role['role'],
            'foto'         => $user['foto'],
            'isLoggedIn'   => true
        ]);
        return redirect()->to(base_url('dashboard'));
    }

    public function storeRegister()
    {
        $userModel      = new UserModel();
        $konsumenModel  = new KonsumenModel();
        $pemilikModel   = new PemilikKostModel();
        $roleModel      = new RoleModel();
        $name      = $this->request->getPost('name');
        $username  = $this->request->getPost('username');
        $role      = $this->request->getPost('role');
        $phone     = $this->request->getPost('phone');
        $alamat    = $this->request->getPost('alamat');
        $password = password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        );
        $roleData = $roleModel
            ->where('Role', $role)
            ->first();
        if (!$roleData) {
            return redirect()->back()->with('error', 'Role tidak valid');
        }
        $userData = [
            'nama'      => $name,
            'username'  => $username,
            'role_id'   => $roleData['role_id'],
            'no_hp'     => $phone,
            'password'  => $password
        ];
        if (!$userModel->insert($userData)) {
            return redirect()->back()->with(
                'error',
                'Registrasi gagal.'
            );
        }
        $idUser = $userModel->getInsertID();
        if ($role == 'konsumen') {
            $konsumenModel->insert([
                'id_user' => $idUser,
                'alamat'  => $alamat
            ]);
        } elseif ($role == 'pemilik') {
            $pemilikModel->insert([
                'id_user' => $idUser,
                'alamat'  => $alamat
            ]);
        }

        $notifikasiHelper = new NotifikasiHelper();
        $notifikasiHelper->notifikasiPenggunaBaru($idUser, $name);

        return redirect()->to(base_url('login'))
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
