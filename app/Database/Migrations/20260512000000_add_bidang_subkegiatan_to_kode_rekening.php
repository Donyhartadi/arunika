<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBidangSubkegiatanToKodeRekening extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kode_rekening', [
            'bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'no_rekening',
            ],
            'sub_kegiatan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'bidang',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kode_rekening', ['bidang', 'sub_kegiatan']);
    }
}
