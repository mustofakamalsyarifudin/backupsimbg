<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanRequestModel extends Model
{
    protected $table = 'bahan_request';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_sppg',
        'nama_bahan',
        'satuan',
        'keterangan',
        'status',
        'requested_by',
        'processed_by',
        'processed_at',
        'rejection_reason',
        'master_bahan_id',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
