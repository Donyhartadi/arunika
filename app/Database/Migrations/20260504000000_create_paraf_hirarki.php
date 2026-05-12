<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParafHirarki extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nomor' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Urutan baris paraf hirarki (1, 2, 3)',
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('paraf_hirarki');

        $now = date('Y-m-d H:i:s');
        $this->db->table('paraf_hirarki')->insertBatch([
            ['nomor' => 1, 'label' => 'Sekretaris Dinas',              'updated_at' => $now],
            ['nomor' => 2, 'label' => 'Kepala Bidang Persandian dan KI', 'updated_at' => $now],
            ['nomor' => 3, 'label' => 'Pelaksana',                     'updated_at' => $now],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('paraf_hirarki');
    }
}
