<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBakuDetailModel extends Model
{
    protected $table = 'bahan_baku_detail';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'belanja_id',
        'bahan_id',
        'nama_bahan',
        'qty',
        'satuan',
        'harga',
        'total_harga',
        'updated_by'
    ];

    protected $useTimestamps = false;
}
