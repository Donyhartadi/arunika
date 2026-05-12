<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jenis_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'default' => 'Surat Dinas',
            ],
            'nomor' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'pangkat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tingkat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'asal' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tujuan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'perihal' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bulan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'plat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'alat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'lama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'berangkat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kembali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'no_rekening' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_rekening' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'template_choice' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('surat_logs');
    }

    public function down()
    {
        $this->forge->dropTable('surat_logs');
    }
}
