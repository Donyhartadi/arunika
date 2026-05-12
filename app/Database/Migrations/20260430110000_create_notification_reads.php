<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationReads extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'user_id'         => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'notification_id' => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'read_at'         => ['type' => 'DATETIME', 'null' => false, 'default' => date('Y-m-d H:i:s')],
        ]);
        $this->forge->addPrimaryKey(['user_id', 'notification_id']);
        $this->forge->addKey('notification_id');
        $this->forge->createTable('notification_reads');
    }

    public function down(): void
    {
        $this->forge->dropTable('notification_reads', true);
    }
}
