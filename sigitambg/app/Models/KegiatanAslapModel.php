<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanAslapModel extends Model
{
    protected $table = 'kegiatan_aslap';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'id_sppg',
        'tanggal',
        'judul_kegiatan',
        'lokasi',
        'deskripsi',
        'created_by'

    ];

    protected $useTimestamps = true;
}
