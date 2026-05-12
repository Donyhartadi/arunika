<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBbmDexlite extends Migration
{
    public function up()
    {
        $this->db->table('pengaturan_perjadin')->insert([
            'kunci'      => 'bbm_dexlite',
            'nilai'      => 13950,
            'label'      => 'Dexlite',
            'grup'       => 'bbm',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->db->table('pengaturan_perjadin')->where('kunci', 'bbm_dexlite')->delete();
    }
}
