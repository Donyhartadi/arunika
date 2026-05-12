<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratLogModel extends Model
{
    protected $table = 'surat_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jenis_surat',
        'nomor',
        'tanggal',
        'nama',
        'nip',
        'pangkat',
        'tingkat',
        'nip_pengikut_1',
        'nip_pengikut_2',
        'nip_pengikut_3',
        'jabatan',
        'asal',
        'tujuan',
        'perihal',
        'bulan',
        'plat',
        'alat',
        'lama',
        'berangkat',
        'kembali',
        'instansi',
        'no_rekening',
        'nama_rekening',
        'template_choice',
        'filename',
        'rincian_filename',
        'rincian_kategori',
        'rincian_uang_harian',
        'rincian_uang_penginapan',
        'rincian_biaya_transport',
        'rincian_biaya_lain',
        'rincian_jumlah_total',
        'rincian_terbilang',
        'kwitansi_filename',
        'notadinas_filename',
        'user',
        'unit_kerja',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';
}