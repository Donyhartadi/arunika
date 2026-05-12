<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNotadinasFilenameToSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_logs', [
            'notadinas_filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'kwitansi_filename',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_logs', 'notadinas_filename');
    }
}
