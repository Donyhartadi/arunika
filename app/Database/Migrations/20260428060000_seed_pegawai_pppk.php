<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeedPegawaiPppk extends Migration
{
    public function up()
    {
        // 36 pegawai PPPK dari daftar. INSERT IGNORE — skip jika NIP sudah ada.
        $pegawai = [
            // Gol. IX – Ahli Pertama
            ['nip' => '198011202023211011', 'nama' => 'Kodarudin, S. Kom',                          'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Ahli Pertama Pranata Komputer'],
            ['nip' => '199606032024211022', 'nama' => 'Yeri Saputra, S.Kom',                        'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Ahli Pertama Pranata Komputer'],
            ['nip' => '198508302025211033', 'nama' => 'Rian Ari Wijaya, S.Kom.',                    'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '199408282025211054', 'nama' => 'Iljas Mulkat, S.H.',                         'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '198804082025212034', 'nama' => 'Anita Afrilia, S.E',                         'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '198609092025212051', 'nama' => 'Etika Delpia, S.H.',                         'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '200108152025212004', 'nama' => 'Amelia Agustin, S.H.',                       'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '198902112025212030', 'nama' => 'Febryanti, S.H.',                            'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '199507132025211020', 'nama' => 'M. Raka Raenaldo, S.E.',                     'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '199802092025212014', 'nama' => 'Allhayatuminal Iman, S.H.',                  'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '199708202025211031', 'nama' => 'Andre Leonardo Qomarul Bait, S.H.',          'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '199908092025212017', 'nama' => 'Angraini, S.H.',                             'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. IX', 'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            // Gol. VII – Terampil / Pengelola
            ['nip' => '198101172023212017', 'nama' => 'Alita Handayani, A.Md',                      'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. VII', 'tingkat' => 'C3', 'jabatan' => 'Terampil Pranata Komputer'],
            ['nip' => '199412162024211027', 'nama' => 'Patrio Rachman, A.Md., Kom',                 'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. VII', 'tingkat' => 'C3', 'jabatan' => 'Terampil Pranata Komputer'],
            ['nip' => '200102072025212007', 'nama' => 'Silvia Nisundari, A.Md., Kom.',              'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. VII', 'tingkat' => 'C3', 'jabatan' => 'Pengelola Layanan Operasional'],
            ['nip' => '199910202025211014', 'nama' => 'Unggul Cahyo Putro, A.Md.,Kom.',             'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. VII', 'tingkat' => 'C3', 'jabatan' => 'Pengelola Layanan Operasional'],
            ['nip' => '198402192025212024', 'nama' => 'Wahyu Muamaroh Dwining Tyas, A.Md',         'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. VII', 'tingkat' => 'C3', 'jabatan' => 'Pengelola Layanan Operasional'],
            ['nip' => '199108042025211033', 'nama' => 'Agiean Perdana',                             'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. VII', 'tingkat' => 'C3', 'jabatan' => 'Pengelola Layanan Operasional'],
            // Gol. V – Pelaksana
            ['nip' => '199405252025211019', 'nama' => 'Derman Syahardi',                            'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '199906112025211042', 'nama' => 'Megi Junizar',                               'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198910102025212057', 'nama' => 'Lidia Wati',                                 'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198809142025212042', 'nama' => 'Septi Nurmala Dewi',                         'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '200202072025212001', 'nama' => 'Destia Estika Ayu Putri',                    'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198711102025212052', 'nama' => 'Anita Indriyani',                            'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198504062025212057', 'nama' => 'Sri Tugiyanti',                              'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198310242025211022', 'nama' => 'Andri. S',                                   'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198101232025211025', 'nama' => 'Hendro',                                     'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198403272025211036', 'nama' => 'Mardianto',                                  'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '199811092025211014', 'nama' => 'Quraysh Muhammad Khalif',                    'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '200007212025211019', 'nama' => 'Apriadi',                                    'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '199212312025212087', 'nama' => 'Siska Utami',                                'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '198803032025211051', 'nama' => 'Fery Fadli',                                 'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Pengadministrasian Perkantoran'],
            ['nip' => '200406012025211001', 'nama' => 'Aryakrisna Arjunsyah',                       'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Operator Layanan Operasional'],
            ['nip' => '199310032025211041', 'nama' => 'Okta Candra Mulia',                          'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Operator Layanan Operasional'],
            ['nip' => '198607162025211049', 'nama' => 'Tomi Putra Wijaya',                          'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Operator Layanan Operasional'],
            ['nip' => '199502042025211031', 'nama' => 'Rahmad Hidayat',                             'lahir' => '', 'status' => 'PPPK', 'pangkat' => 'PPPK / Gol. V',   'tingkat' => 'C3', 'jabatan' => 'Operator Layanan Operasional'],
        ];

        foreach ($pegawai as $row) {
            $this->db->query(
                "INSERT IGNORE INTO pegawai (nip, nama, lahir, status, pangkat, tingkat, jabatan) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$row['nip'], $row['nama'], $row['lahir'], $row['status'], $row['pangkat'], $row['tingkat'], $row['jabatan']]
            );
        }
    }

    public function down()
    {
        $nips = [
            '198011202023211011','199606032024211022','198508302025211033',
            '199408282025211054','198804082025212034','198609092025212051',
            '200108152025212004','199507132025211020','199802092025212014',
            '199708202025211031','198101172023212017','199412162024211027',
            '200102072025212007','199910202025211014','198402192025212024',
            '199108042025211033','199405252025211019','199906112025211042',
            '198910102025212057','198809142025212042','200202072025212001',
            '198310242025211022','198101232025211025','198403272025211036',
            '199811092025211014','200007212025211019','199212312025212087',
            '198803032025211051','200406012025211001','199310032025211041',
            '198607162025211049','199502042025211031',
        ];
        $this->db->table('pegawai')->whereIn('nip', $nips)->delete();
    }
}
