<?php

namespace App\Models;

use CodeIgniter\Model;

class DasarSuratModel extends Model
{
    protected $table          = 'dasar_surat';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields  = ['nomor', 'isi', 'updated_at'];
    protected $useTimestamps  = false;

    /**
     * Return all rows ordered by nomor, as a flat list.
     */
    public function getAll(): array
    {
        return $this->orderBy('nomor', 'ASC')->findAll();
    }
}
