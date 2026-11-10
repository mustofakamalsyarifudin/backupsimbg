<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterBahanHargaModel extends Model
{
    protected $table = 'master_bahan_harga';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'bahan_id',
        'harga_lama',
        'harga_baru',
        'diubah_oleh',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
