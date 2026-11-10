<?php

namespace App\Models;

use CodeIgniter\Model;

class UserActivityLogModel extends Model
{
    protected $table = 'user_activity_logs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'user_id',
        'id_sppg',
        'user_level',
        'username',
        'activity',
        'module',
        'method',
        'uri',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    /**
     * Catat aktivitas tanpa mengganggu request utama apabila logging gagal.
     */
    public function record(array $data): void
    {
        try {
            $this->insert($data, false);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal mencatat audit aktivitas: {message}', ['message' => $e->getMessage()]);
        }
    }
}
