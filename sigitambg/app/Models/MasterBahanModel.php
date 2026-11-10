<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterBahanModel extends Model
{
    protected $table = 'master_bahan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_sppg',
        'nama_bahan',
        'satuan_default',
        'harga',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
