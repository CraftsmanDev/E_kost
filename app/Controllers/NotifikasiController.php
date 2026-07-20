<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;
use App\Models\PemilikKostModel;

class NotifikasiController extends BaseController
{
    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
        $this->pemilikKostModel = new PemilikKostModel();
    }

    public function getNotifikasi()
    {
        try {
            $role = session()->get('role');
            $idUser = session()->get('user_id');
            $idPemilik = null;

            if ($role === 'pemilik') {
                $pemilik = $this->pemilikKostModel->where('id_user', $idUser)->first();
                $idPemilik = $pemilik['id_pemilik'] ?? null;
            }

            try {
                $this->autoDeleteOldNotifications($idUser, $role, $idPemilik);
            } catch (\Exception $e) {
                log_message('error', 'Auto-delete notifications failed: ' . $e->getMessage());
            }

            $limit = $this->request->getGet('limit') ?? 10;
            $notifikasi = [];

            if ($role === 'admin') {
                $notifikasi = $this->notifikasiModel->getNotifikasiByRole($role, $limit);
            } elseif ($role === 'pemilik' && $idPemilik) {
                $notifikasi = $this->notifikasiModel->getNotifikasiByPemilik($idPemilik, $limit);
            } elseif ($role === 'konsumen') {
                $notifikasi = $this->notifikasiModel->getNotifikasiByUser($idUser, $role, $limit);
            }

            foreach ($notifikasi as &$notif) {
                $notif['relative_time'] = $this->notifikasiModel->getRelativeTime($notif['created_at']);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $notifikasi
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'data' => [],
                'message' => 'Error loading notifications'
            ]);
        }
    }

    private function autoDeleteOldNotifications($idUser, $role, $idPemilik = null)
    {
        try {
            $builder = $this->notifikasiModel->builder();
            $builder->where('status_baca', 1);

            $db = \Config\Database::connect();
            $fields = $db->getFieldNames('notifikasi');

            if (in_array('read_at', $fields)) {
                $builder->where('read_at <', date('Y-m-d H:i:s', strtotime('-24 hours')));
            } else {
                $builder->where('created_at <', date('Y-m-d H:i:s', strtotime('-24 hours')));
            }

            if ($role === 'pemilik' && $idPemilik) {
                $builder->where('role', 'pemilik')->where('id_pemilik', $idPemilik);
            } elseif ($role === 'konsumen') {
                $builder->where('role', 'konsumen')->where('id_user', $idUser);
            } elseif ($role === 'admin') {
                $builder->where('role', 'admin');
            }

            $builder->delete();
        } catch (\Exception $e) {
            log_message('error', 'Auto-delete notifications error: ' . $e->getMessage());
        }
    }

    public function getUnreadCount()
    {
        try {
            $role = session()->get('role');
            $idUser = session()->get('user_id');
            $idPemilik = null;

            if ($role === 'pemilik') {
                $pemilik = $this->pemilikKostModel->where('id_user', $idUser)->first();
                $idPemilik = $pemilik['id_pemilik'] ?? null;
            }

            $count = $this->notifikasiModel->getUnreadCount($idUser, $role, $idPemilik);

            return $this->response->setJSON([
                'status' => 'success',
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'count' => 0,
                'message' => 'Error getting unread count'
            ]);
        }
    }

    public function markAsRead($id)
    {
        try {
            $result = $this->notifikasiModel->markAsRead($id);

            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Notifikasi ditandai sebagai sudah dibaca'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menandai notifikasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error marking notification as read'
            ]);
        }
    }

    public function markAllAsRead()
    {
        try {
            $role = session()->get('role');
            $idUser = session()->get('user_id');
            $idPemilik = null;

            if ($role === 'pemilik') {
                $pemilik = $this->pemilikKostModel->where('id_user', $idUser)->first();
                $idPemilik = $pemilik['id_pemilik'] ?? null;
            }

            $result = $this->notifikasiModel->markAllAsRead($idUser, $role, $idPemilik);

            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menandai semua notifikasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error marking all notifications as read'
            ]);
        }
    }

    public function delete($id)
    {
        $result = $this->notifikasiModel->deleteNotifikasi($id);

        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Notifikasi berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus notifikasi'
            ]);
        }
    }
}
