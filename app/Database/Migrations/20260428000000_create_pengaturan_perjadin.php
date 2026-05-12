<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaturanPerjadin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kunci' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nilai' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'grup' => [
                'type'       => 'ENUM',
                'constraint' => ['uang_harian', 'bbm', 'penginapan'],
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('kunci', true);
        $this->forge->createTable('pengaturan_perjadin');

        $now = date('Y-m-d H:i:s');

        $this->db->table('pengaturan_perjadin')->insertBatch([
            // Uang Harian
            ['kunci' => 'harian_dalam_daerah',               'nilai' => 150000,  'label' => 'Dalam Daerah',               'grup' => 'uang_harian', 'updated_at' => $now],
            ['kunci' => 'harian_luar_daerah_dalam_provinsi',  'nilai' => 380000,  'label' => 'Luar Daerah Dalam Provinsi', 'grup' => 'uang_harian', 'updated_at' => $now],
            ['kunci' => 'harian_luar_daerah_luar_provinsi',   'nilai' => 380000,  'label' => 'Luar Daerah Luar Provinsi',  'grup' => 'uang_harian', 'updated_at' => $now],
            // Harga BBM
            ['kunci' => 'bbm_pertalite',       'nilai' => 10000,  'label' => 'Pertalite',       'grup' => 'bbm', 'updated_at' => $now],
            ['kunci' => 'bbm_pertamax',        'nilai' => 12950,  'label' => 'Pertamax',        'grup' => 'bbm', 'updated_at' => $now],
            ['kunci' => 'bbm_pertamax_green',  'nilai' => 13900,  'label' => 'Pertamax Green',  'grup' => 'bbm', 'updated_at' => $now],
            ['kunci' => 'bbm_pertamax_turbo',  'nilai' => 14400,  'label' => 'Pertamax Turbo',  'grup' => 'bbm', 'updated_at' => $now],
            ['kunci' => 'bbm_solar',           'nilai' => 6800,   'label' => 'Solar',           'grup' => 'bbm', 'updated_at' => $now],
            // Pagu Penginapan
            ['kunci' => 'pagu_C1', 'nilai' => 1955000, 'label' => 'Golongan C1', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_C2', 'nilai' => 861000,  'label' => 'Golongan C2', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_C3', 'nilai' => 861000,  'label' => 'Golongan C3', 'grup' => 'penginapan', 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan_perjadin');
    }
}
