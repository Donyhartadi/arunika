<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanPerjadinModel extends Model
{
    protected $table          = 'pengaturan_perjadin';
    protected $primaryKey     = 'kunci';
    protected $useAutoIncrement = false;
    protected $returnType     = 'array';
    protected $allowedFields  = ['kunci', 'nilai', 'label', 'grup', 'updated_at'];

    /**
     * Ambil semua setting sebagai map kunci => nilai (integer)
     */
    public function getAllAsMap(): array
    {
        $rows = $this->findAll();
        $map  = [];
        foreach ($rows as $row) {
            $map[$row['kunci']] = (int) $row['nilai'];
        }
        return $map;
    }

    /**
     * Ambil setting per grup (uang_harian | bbm | penginapan)
     */
    public function getByGrup(string $grup): array
    {
        return $this->where('grup', $grup)->orderBy('kunci', 'ASC')->findAll();
    }
}
