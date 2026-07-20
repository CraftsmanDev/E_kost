<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNotifications extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notifikasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'id_pemilik' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'pesan' => [
                'type'       => 'TEXT',
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'info',
            ],
            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status_baca' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'data_terkait' => [
                'type'       => 'JSON',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_notifikasi', true);
        $this->forge->addKey('id_user');
        $this->forge->addKey('id_pemilik');
        $this->forge->addKey('role');
        $this->forge->addKey('status_baca');
        $this->forge->createTable('notifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('notifikasi');
    }
}
