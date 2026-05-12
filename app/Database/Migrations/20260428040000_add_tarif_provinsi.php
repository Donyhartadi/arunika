<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTarifProvinsi extends Migration
{
    public function up()
    {
        // Ubah ENUM agar mendukung grup tarif_provinsi
        $this->db->query("ALTER TABLE pengaturan_perjadin MODIFY grup ENUM('uang_harian','bbm','penginapan','tarif_provinsi') NOT NULL");

        $now = date('Y-m-d H:i:s');

        $this->db->table('pengaturan_perjadin')->insertBatch([
            ['kunci' => 'provinsi_aceh',                     'nilai' => 360000, 'label' => 'Aceh',                     'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sumatera_utara',           'nilai' => 370000, 'label' => 'Sumatera Utara',           'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_riau',                     'nilai' => 370000, 'label' => 'Riau',                     'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_kepulauan_riau',           'nilai' => 370000, 'label' => 'Kepulauan Riau',           'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_jambi',                    'nilai' => 380000, 'label' => 'Jambi',                    'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sumatera_barat',           'nilai' => 380000, 'label' => 'Sumatera Barat',           'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sumatera_selatan',         'nilai' => 380000, 'label' => 'Sumatera Selatan',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_lampung',                  'nilai' => 380000, 'label' => 'Lampung',                  'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_bengkulu',                 'nilai' => 380000, 'label' => 'Bengkulu',                 'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_bangka_belitung',          'nilai' => 410000, 'label' => 'Bangka Belitung',          'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_banten',                   'nilai' => 370000, 'label' => 'Banten',                   'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_jawa_barat',               'nilai' => 370000, 'label' => 'Jawa Barat',               'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_dki_jakarta',              'nilai' => 530000, 'label' => 'D.K.I. Jakarta',           'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_jawa_tengah',              'nilai' => 370000, 'label' => 'Jawa Tengah',              'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_di_yogyakarta',            'nilai' => 420000, 'label' => 'D.I. Yogyakarta',          'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_jawa_timur',               'nilai' => 410000, 'label' => 'Jawa Timur',               'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_bali',                     'nilai' => 480000, 'label' => 'Bali',                     'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_ntb',                      'nilai' => 440000, 'label' => 'Nusa Tenggara Barat',      'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_ntt',                      'nilai' => 430000, 'label' => 'Nusa Tenggara Timur',      'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_kalimantan_barat',         'nilai' => 380000, 'label' => 'Kalimantan Barat',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_kalimantan_tengah',        'nilai' => 360000, 'label' => 'Kalimantan Tengah',        'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_kalimantan_selatan',       'nilai' => 380000, 'label' => 'Kalimantan Selatan',       'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_kalimantan_timur',         'nilai' => 400000, 'label' => 'Kalimantan Timur',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_kalimantan_utara',         'nilai' => 430000, 'label' => 'Kalimantan Utara',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sulawesi_utara',           'nilai' => 370000, 'label' => 'Sulawesi Utara',           'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_gorontalo',                'nilai' => 370000, 'label' => 'Gorontalo',                'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sulawesi_barat',           'nilai' => 410000, 'label' => 'Sulawesi Barat',           'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sulawesi_selatan',         'nilai' => 430000, 'label' => 'Sulawesi Selatan',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sulawesi_tengah',          'nilai' => 370000, 'label' => 'Sulawesi Tengah',          'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_sulawesi_tenggara',        'nilai' => 380000, 'label' => 'Sulawesi Tenggara',        'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_maluku',                   'nilai' => 380000, 'label' => 'Maluku',                   'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_maluku_utara',             'nilai' => 430000, 'label' => 'Maluku Utara',             'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_papua_barat',              'nilai' => 480000, 'label' => 'Papua Barat',              'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_papua_barat_daya',         'nilai' => 480000, 'label' => 'Papua Barat Daya',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_papua',                    'nilai' => 580000, 'label' => 'Papua',                    'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_papua_selatan',            'nilai' => 580000, 'label' => 'Papua Selatan',            'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_papua_tengah',             'nilai' => 580000, 'label' => 'Papua Tengah',             'grup' => 'tarif_provinsi', 'updated_at' => $now],
            ['kunci' => 'provinsi_papua_pegunungan',         'nilai' => 580000, 'label' => 'Papua Pegunungan',         'grup' => 'tarif_provinsi', 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        $this->db->table('pengaturan_perjadin')
                 ->where('grup', 'tarif_provinsi')
                 ->delete();

        $this->db->query("ALTER TABLE pengaturan_perjadin MODIFY grup ENUM('uang_harian','bbm','penginapan') NOT NULL");
    }
}
