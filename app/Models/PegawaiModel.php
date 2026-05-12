<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table = 'pegawai'; // sesuaikan nama tabel
    protected $primaryKey = 'nip'; // karena NIP unik

    protected $allowedFields = [
        'nama',
        'lahir',
        'status',
        'pangkat',
        'nip',
        'tingkat',
        'jabatan'
    ];
}