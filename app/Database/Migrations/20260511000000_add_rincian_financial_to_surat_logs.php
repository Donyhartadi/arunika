<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRincianFinancialToSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_logs', [
            'rincian_uang_harian' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_filename',
            ],
            'rincian_biaya_transport' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_uang_harian',
            ],
            'rincian_jumlah_total' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_biaya_transport',
            ],
            'rincian_terbilang' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
                'after'   => 'rincian_jumlah_total',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_logs', [
            'rincian_uang_harian',
            'rincian_biaya_transport',
            'rincian_jumlah_total',
            'rincian_terbilang',
        ]);
    }
}
