<?php

namespace App\Models;

use CodeIgniter\Model;

class PMKelasModel extends Model
{
    protected $table = 'pm_kelas';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'pm_id',
        'jenjang_id',
        'nama_kelas',
        'jumlah_siswa',
        'jumlah_alergi',
        'catatan_alergi',
        'porsi'
    ];

    protected $useTimestamps = false;
}
