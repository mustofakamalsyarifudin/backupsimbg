<?php

namespace App\Models;

use CodeIgniter\Model;

class KoperasiSppgModel extends Model
{
    protected $table = 'koperasi_sppg';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'koperasi_id',
        'id_sppg',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
