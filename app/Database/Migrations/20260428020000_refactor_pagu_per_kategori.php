<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorPaguPerKategori extends Migration
{
    public function up()
    {
        $now = date('Y-m-d H:i:s');

        // Ambil nilai lama untuk migrasi data
        $oldC1 = (int) ($this->db->table('pengaturan_perjadin')->where('kunci', 'pagu_C1')->get()->getRowArray()['nilai'] ?? 1955000);
        $oldC2 = (int) ($this->db->table('pengaturan_perjadin')->where('kunci', 'pagu_C2')->get()->getRowArray()['nilai'] ?? 861000);
        $oldC3 = (int) ($this->db->table('pengaturan_perjadin')->where('kunci', 'pagu_C3')->get()->getRowArray()['nilai'] ?? 861000);

        // Hapus baris lama
        $this->db->table('pengaturan_perjadin')
                 ->whereIn('kunci', ['pagu_C1', 'pagu_C2', 'pagu_C3'])
                 ->delete();

        // Masukkan 9 baris baru (3 kategori × 3 golongan)
        $this->db->table('pengaturan_perjadin')->insertBatch([
            // Dalam Daerah (biasanya tidak ada penginapan, default 0)
            ['kunci' => 'pagu_dalam_daerah_C1', 'nilai' => 0,      'label' => 'Dalam Daerah – Gol. C1', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_dalam_daerah_C2', 'nilai' => 0,      'label' => 'Dalam Daerah – Gol. C2', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_dalam_daerah_C3', 'nilai' => 0,      'label' => 'Dalam Daerah – Gol. C3', 'grup' => 'penginapan', 'updated_at' => $now],
            // Luar Daerah Dalam Provinsi
            ['kunci' => 'pagu_luar_daerah_dalam_provinsi_C1', 'nilai' => $oldC1, 'label' => 'Luar Daerah Dalam Provinsi – Gol. C1', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_luar_daerah_dalam_provinsi_C2', 'nilai' => $oldC2, 'label' => 'Luar Daerah Dalam Provinsi – Gol. C2', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_luar_daerah_dalam_provinsi_C3', 'nilai' => $oldC3, 'label' => 'Luar Daerah Dalam Provinsi – Gol. C3', 'grup' => 'penginapan', 'updated_at' => $now],
            // Luar Daerah Luar Provinsi
            ['kunci' => 'pagu_luar_daerah_luar_provinsi_C1', 'nilai' => $oldC1, 'label' => 'Luar Daerah Luar Provinsi – Gol. C1', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_luar_daerah_luar_provinsi_C2', 'nilai' => $oldC2, 'label' => 'Luar Daerah Luar Provinsi – Gol. C2', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_luar_daerah_luar_provinsi_C3', 'nilai' => $oldC3, 'label' => 'Luar Daerah Luar Provinsi – Gol. C3', 'grup' => 'penginapan', 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        $now = date('Y-m-d H:i:s');

        // Ambil nilai luar luar provinsi untuk restore
        $c1 = (int) ($this->db->table('pengaturan_perjadin')->where('kunci', 'pagu_luar_daerah_luar_provinsi_C1')->get()->getRowArray()['nilai'] ?? 1955000);
        $c2 = (int) ($this->db->table('pengaturan_perjadin')->where('kunci', 'pagu_luar_daerah_luar_provinsi_C2')->get()->getRowArray()['nilai'] ?? 861000);
        $c3 = (int) ($this->db->table('pengaturan_perjadin')->where('kunci', 'pagu_luar_daerah_luar_provinsi_C3')->get()->getRowArray()['nilai'] ?? 861000);

        // Hapus 9 baris baru
        $this->db->table('pengaturan_perjadin')
                 ->like('kunci', 'pagu_dalam_daerah', 'after')
                 ->orLike('kunci', 'pagu_luar_daerah_dalam_provinsi', 'after')
                 ->orLike('kunci', 'pagu_luar_daerah_luar_provinsi', 'after')
                 ->delete();

        // Restore 3 baris lama
        $this->db->table('pengaturan_perjadin')->insertBatch([
            ['kunci' => 'pagu_C1', 'nilai' => $c1, 'label' => 'Golongan C1', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_C2', 'nilai' => $c2, 'label' => 'Golongan C2', 'grup' => 'penginapan', 'updated_at' => $now],
            ['kunci' => 'pagu_C3', 'nilai' => $c3, 'label' => 'Golongan C3', 'grup' => 'penginapan', 'updated_at' => $now],
        ]);
    }
}
