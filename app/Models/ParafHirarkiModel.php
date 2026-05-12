<?php

namespace App\Models;

use CodeIgniter\Model;

class ParafHirarkiModel extends Model
{
    protected $table            = 'paraf_hirarki';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nomor', 'label', 'updated_at'];
    protected $useTimestamps    = false;

    /**
     * Return all rows ordered by nomor.
     */
    public function getAll(): array
    {
        return $this->orderBy('nomor', 'ASC')->findAll();
    }
}
