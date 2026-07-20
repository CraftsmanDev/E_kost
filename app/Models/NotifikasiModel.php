<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table      = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $allowedFields = [
        'id_user',
        'role',
        'id_pemilik',
        'judul',
        'pesan',
        'tipe',
        'link',
        'status_baca',
        'data_terkait',
        'created_at',
        'read_at'
    ];

    public function getNotifikasiByUser($idUser, $role, $limit = 10)
    {
        if (empty($idUser) || empty($role)) {
            return [];
        }

        return $this->builder()
            ->where('id_user', $idUser)
            ->where('role', $role)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getNotifikasiByPemilik($idPemilik, $limit = 10)
    {
        if (empty($idPemilik)) {
            return [];
        }

        return $this->builder()
            ->where('role', 'pemilik')
            ->where('id_pemilik', $idPemilik)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getNotifikasiByRole($role, $limit = 10)
    {
        if (empty($role)) {
            return [];
        }

        return $this->builder()
            ->where('role', $role)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getUnreadCount($idUser, $role, $idPemilik = null)
    {
        if (empty($role)) {
            return 0;
        }

        $builder = $this->where('status_baca', false)
                       ->where('role', $role);

        if ($role === 'pemilik' && $idPemilik) {
            $builder->where('id_pemilik', $idPemilik);
        } elseif ($role === 'konsumen' && $idUser) {
            $builder->where('id_user', $idUser);
        }

        return $builder->countAllResults();
    }

    public function markAsRead($idNotifikasi)
    {
        $updateData = ['status_baca' => true];

        // Check if read_at column exists
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('notifikasi');

        if (in_array('read_at', $fields)) {
            $updateData['read_at'] = date('Y-m-d H:i:s');
        }

        return $this->update($idNotifikasi, $updateData);
    }

    public function markAllAsRead($idUser, $role, $idPemilik = null)
    {
        $builder = $this->where('status_baca', false)
                       ->where('role', $role);

        if ($role === 'pemilik' && $idPemilik) {
            $builder->where('id_pemilik', $idPemilik);
        } else {
            $builder->where('id_user', $idUser);
        }

        $updateData = ['status_baca' => true];

        // Check if read_at column exists
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('notifikasi');

        if (in_array('read_at', $fields)) {
            $updateData['read_at'] = date('Y-m-d H:i:s');
        }

        return $builder->update($updateData);
    }

    public function createNotifikasi($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        $result = $this->insert($data);

        if ($result === false) {
            dd([
                'model_errors' => $this->errors(),
                'db_error'     => $this->db->error(),
                'data'         => $data,
            ]);
        }

        return $result;
    }

    public function deleteNotifikasi($idNotifikasi)
    {
        return $this->delete($idNotifikasi);
    }

    public function getRelativeTime($datetime)
    {
        $time = strtotime($datetime);
        $now = time();
        $diff = $now - $time;

        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' menit yang lalu';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' jam yang lalu';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' hari yang lalu';
        } else {
            return date('d M Y', $time);
        }
    }
}
