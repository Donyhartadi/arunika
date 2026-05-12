<?php

namespace App\Models;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    protected $table = 'kode_rekening';
    protected $primaryKey = 'id_rekening';
    protected $allowedFields = ['nama_rekening', 'no_rekening', 'bidang', 'sub_kegiatan'];
}