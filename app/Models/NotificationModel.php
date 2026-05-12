<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table         = 'notifications';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['judul', 'pesan', 'tipe', 'aktif', 'created_by'];
    protected $useTimestamps = true;

    /** Ambil semua notifikasi aktif */
    public function getAktif(): array
    {
        return $this->where('aktif', 1)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil notifikasi aktif yang belum pernah dibaca oleh user.
     */
    public function getUnreadForUser(int $userId): array
    {
        return $this->db->table('notifications n')
            ->select('n.*')
            ->where('n.aktif', 1)
            ->whereNotIn('n.id',
                function ($builder) use ($userId) {
                    $builder->select('notification_id')
                            ->from('notification_reads')
                            ->where('user_id', $userId);
                }
            )
            ->orderBy('n.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca oleh user.
     *
     * @param int   $userId
     * @param int[] $notifIds
     */
    public function markRead(int $userId, array $notifIds): void
    {
        if (empty($notifIds)) {
            return;
        }
        $rows = [];
        foreach ($notifIds as $nid) {
            $rows[] = [
                'user_id'         => $userId,
                'notification_id' => (int) $nid,
                'read_at'         => date('Y-m-d H:i:s'),
            ];
        }
        // INSERT IGNORE to avoid duplicate key errors
        $this->db->table('notification_reads')
                 ->ignore(true)
                 ->insertBatch($rows);
    }

    /**
     * Hapus semua read-record saat notifikasi diaktifkan kembali
     * (agar user melihatnya lagi).
     */
    public function clearReads(int $notifId): void
    {
        $this->db->table('notification_reads')
                 ->where('notification_id', $notifId)
                 ->delete();
    }
}
