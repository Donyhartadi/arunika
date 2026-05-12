<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeedDaftarPegawai extends Migration
{
    public function up()
    {
        // Gunakan INSERT IGNORE agar baris yang NIP-nya sudah ada tidak menimpa data existing
        $pegawai = [
            // --- Golongan IV (C1) ---
            ['nip' => '197603312000122003', 'nama' => 'Vivi Mariani, S.Si., M.Bmd., Apt.',           'lahir' => '', 'status' => '', 'pangkat' => 'Pembina Utama Muda / (IV.c)', 'tingkat' => 'C1', 'jabatan' => 'Kepala Dinas'],
            ['nip' => '197508132009011005', 'nama' => 'Erwin Faisal, S. Kom., M.M.',                 'lahir' => '', 'status' => '', 'pangkat' => 'Pembina / (IV.a)',            'tingkat' => 'C1', 'jabatan' => 'Sekretaris'],
            ['nip' => '198404032009041003', 'nama' => 'Harry Aries Saputra, S.E., M.M.',             'lahir' => '', 'status' => '', 'pangkat' => 'Pembina / (IV.a)',            'tingkat' => 'C1', 'jabatan' => 'Kabid Pengelolaan Data Informasi Publik dan Statistik'],
            ['nip' => '197907152006042020', 'nama' => 'Yuliani Indriani, S.H.',                      'lahir' => '', 'status' => '', 'pangkat' => 'Pembina / (IV.a)',            'tingkat' => 'C1', 'jabatan' => 'Kabid Persandian dan Keamanan Informasi'],
            ['nip' => '198009292008011005', 'nama' => 'Ir. Hengky Kurniawan, S. Kom., M. Si.',       'lahir' => '', 'status' => '', 'pangkat' => 'Pembina / (IV.a)',            'tingkat' => 'C1', 'jabatan' => 'Kabid Penyelenggara Egoverment'],
            ['nip' => '197010091998031009', 'nama' => 'Rostom, S.H., M.M.',                          'lahir' => '', 'status' => '', 'pangkat' => 'Pembina / (IV.a)',            'tingkat' => 'C1', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            // --- Golongan III.d dan III.c (C2) ---
            ['nip' => '198607182011011005', 'nama' => 'Zeno, S. Sos., M.I. Kom.',                    'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Kabid Pengelolaan Komunikasi Publik'],
            ['nip' => '197906042010012015', 'nama' => 'Eliyana, S.E., M.M.',                         'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Analis Keuangan Pusat dan Daerah Muda Sub Koordinator Keuangan'],
            ['nip' => '198110232010012015', 'nama' => 'Rida Opriani, S.E., A.k.',                    'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Perencana Muda Sub Koordinator Perencanaan'],
            ['nip' => '198206262010011018', 'nama' => 'Ruslim Anwar, S. Kom.',                       'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Manggala Informasi Muda Sub Koordinator Keamanan Informasi'],
            ['nip' => '197106251994032004', 'nama' => 'Yunita, S.H.',                                'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Sandiman Muda Sub Koordinasi Pengawasan dan Evaluasi Persandian'],
            ['nip' => '198601012011012020', 'nama' => 'Resia Evel Roselin Nesya, S.IP., M.M.',       'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Statistisi Muda Sub Koordinator Statistik'],
            ['nip' => '198207032012012003', 'nama' => 'Resna, S.H.',                                 'lahir' => '', 'status' => '', 'pangkat' => 'Penata Tingkat I / (III.d)', 'tingkat' => 'C2', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            ['nip' => '197607012014091001', 'nama' => 'Budi Indrawijaya, S.H.',                      'lahir' => '', 'status' => '', 'pangkat' => 'Penata / (III.c)',           'tingkat' => 'C2', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '197707032012012009', 'nama' => 'Evi Sudiarti, S.E.',                          'lahir' => '', 'status' => '', 'pangkat' => 'Penata / (III.c)',           'tingkat' => 'C2', 'jabatan' => 'Pranata Siaran Muda Sub Koordinator Kemitraan Komunikasi Publik'],
            ['nip' => '198509262012012004', 'nama' => 'Dian Kurniasih, S.H.',                        'lahir' => '', 'status' => '', 'pangkat' => 'Penata / (III.c)',           'tingkat' => 'C2', 'jabatan' => 'Pranata Hubungan Masyarakat Muda Sub Koordinator Pengelolaan Media Komunikasi'],
            ['nip' => '197804032007012009', 'nama' => 'Rusta Hariany, S. AP., M.M.',                 'lahir' => '', 'status' => '', 'pangkat' => 'Penata / (III.c)',           'tingkat' => 'C2', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            // --- Golongan III.b, III.a, II.c (C3) ---
            ['nip' => '199009122019021005', 'nama' => 'Septa Putra Anggara, S. Kom.',                'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda Tk.I / (III.b)', 'tingkat' => 'C3', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            ['nip' => '199509012019021006', 'nama' => 'Bayu Ghara, S. Kom.',                         'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda Tk.I / (III.b)', 'tingkat' => 'C3', 'jabatan' => 'Kasubbag Umum dan Kepegawaian'],
            ['nip' => '197205022005011002', 'nama' => 'Muhammad Arif',                               'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda Tk.I / (III.b)', 'tingkat' => 'C3', 'jabatan' => 'Operator Layanan Operasional'],
            ['nip' => '198607142012012003', 'nama' => 'Venny Yulia Sari, Si.Kom.',                   'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda Tk.I / (III.b)', 'tingkat' => 'C3', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            ['nip' => '199405052020122012', 'nama' => 'Melinda Dwi Anggraeni, S.Si.',                'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Pengawas Pendataan Statistik'],
            ['nip' => '200205102024091001', 'nama' => 'Rhadif Khasyatullah, S.Tr.I.P',              'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            ['nip' => '199006152025061001', 'nama' => 'Gite Wijaya, S.H.',                           'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Pranata Hubungan Masyarakat Ahli Pertama'],
            ['nip' => '199103292025062001', 'nama' => 'Marta Temala, S.S.I.',                        'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Penata Kelola Sistem dan Teknologi Informasi'],
            ['nip' => '199901082025062002', 'nama' => 'Maharani, S.M.',                              'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Arsiparis Ahli Pertama'],
            ['nip' => '200109242025062002', 'nama' => 'Angelia Sapitri, S. Kom.',                    'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Penata Kelola Sistem dan Teknologi Informasi'],
            ['nip' => '200008062025061002', 'nama' => 'Dony Hartadi, S.Kom.',                        'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Pranata Komputer Ahli Pertama'],
            ['nip' => '200008252025061002', 'nama' => 'Achmad Rivaldi, S.Kom.',                      'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Penata Kelola Sistem dan Teknologi Informasi'],
            ['nip' => '200301132025062001', 'nama' => "Haniyah Qurratul 'Aini, S.M.",                'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Analis Kebijakan Ahli Pertama'],
            ['nip' => '198312132012121004', 'nama' => 'Rudi Hartono, S.M.',                          'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Penata Layanan Operasional'],
            ['nip' => '199901272022011002', 'nama' => 'Andreas Aditama Hutagaol, S.,Ak.',            'lahir' => '', 'status' => '', 'pangkat' => 'Penata Muda / (III.a)',      'tingkat' => 'C3', 'jabatan' => 'Penelaah Teknis Kebijakan'],
            ['nip' => '199305192022032007', 'nama' => 'Indah Suryani, A. Md.',                       'lahir' => '', 'status' => '', 'pangkat' => 'Pengatur / (II.c)',          'tingkat' => 'C3', 'jabatan' => 'Pengelola Data dan Informasi'],
            ['nip' => '200312202025062001', 'nama' => 'Ekma Ermaya, A.Md.Li.',                       'lahir' => '', 'status' => '', 'pangkat' => 'Pengatur / (II.c)',          'tingkat' => 'C3', 'jabatan' => 'Pranata Hubungan Masyarakat Terampil'],
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
            '197603312000122003','197508132009011005','198404032009041003',
            '198009292008011005','197010091998031009','198607182011011005',
            '197906042010012015','198110232010012015','198601012011012020',
            '198207032012012003','197607012014091001','197707032012012009',
            '198509262012012004','197804032007012009','199009122019021005',
            '199509012019021006','197205022005011002','198607142012012003',
            '199405052020122012','200205102024091001','199006152025061001',
            '199103292025062001','199901082025062002','200109242025062002',
            '200008062025061002','200008252025061002','200301132025062001',
            '198312132012121004','199901272022011002','199305192022032007',
            '200312202025062001',
        ];
        $this->db->table('pegawai')->whereIn('nip', $nips)->delete();
    }
}
