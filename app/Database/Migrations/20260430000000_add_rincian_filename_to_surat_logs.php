<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRincianFilenameToSuratLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_logs', [
            'rincian_filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'filename',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_logs', 'rincian_filename');
    }
}
