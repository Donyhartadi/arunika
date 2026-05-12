<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKwitansiFilenameToSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_logs', [
            'kwitansi_filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'rincian_filename',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_logs', 'kwitansi_filename');
    }
}
