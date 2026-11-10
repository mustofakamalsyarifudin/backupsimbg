<?php

namespace App\Models;

use CodeIgniter\Model;

class KoperasiModel extends Model
{
    protected $table = 'koperasi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'kode_koperasi',
        'nama_koperasi',
        'alamat',
        'telepon',
        'email',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
