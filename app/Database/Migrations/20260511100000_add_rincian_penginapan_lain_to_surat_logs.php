<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRincianPenginapanLainToSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_logs', [
            'rincian_uang_penginapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_uang_harian',
            ],
            'rincian_biaya_lain' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_biaya_transport',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_logs', ['rincian_uang_penginapan', 'rincian_biaya_lain']);
    }
}
