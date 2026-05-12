<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDasarSurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nomor' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Urutan nomor dasar (1, 2, 3, ...)',
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dasar_surat');

        $now = date('Y-m-d H:i:s');
        $this->db->table('dasar_surat')->insertBatch([
            ['nomor' => 1, 'isi' => 'Peraturan Daerah Kabupaten Muara Enim Nomor 9 Tahun 2025 tentang Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2026.', 'updated_at' => $now],
            ['nomor' => 2, 'isi' => 'Peraturan Bupati Muara Enim Nomor : 33 Tahun 2025, tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2025.', 'updated_at' => $now],
            ['nomor' => 3, 'isi' => 'Peraturan Bupati Muara Enim Nomor : 1 Tahun 2026 tentang Pedoman Peraturan Perjalanan Dinas Bagi Pejabat Daerah, Aparatur Sipil Negara dan Pihak Lain.', 'updated_at' => $now],
            ['nomor' => 4, 'isi' => 'Keputusan Bupati Muara Enim Nomor : 117/KPTS/BPKAD/2026 Tentang Standar Harga Satuan Biaya Perjalanan Dinas bagi Pejabat Daerah, Aparatur Sipil Negara dan Pihak Lain.', 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('dasar_surat');
    }
}
