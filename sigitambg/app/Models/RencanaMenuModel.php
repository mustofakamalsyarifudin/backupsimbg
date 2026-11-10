<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaMenuModel extends Model
{
    protected $table = 'rencana_menu';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_sppg',
        'tanggal',
        'status',
        'catatan',
        'created_by',
        'ditetapkan_at',
        'ditetapkan_by',
        'dibatalkan_at',
        'dibatalkan_by',
        'alasan_pembatalan',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
