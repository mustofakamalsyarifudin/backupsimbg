<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterJenisKegiatanModel extends Model
{
    protected $table = 'master_jenis_kegiatan';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'nama_kegiatan',

        'urutan',

        'is_active'

    ];

    protected $useTimestamps = true;
}
