<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRincianKategoriToSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_logs', [
            'rincian_kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_filename',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_logs', 'rincian_kategori');
    }
}
