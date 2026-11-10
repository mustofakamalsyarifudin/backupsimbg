<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanGiziModel extends Model
{
    protected $table = 'kegiatan_gizi';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'id_sppg',

        'tanggal',

        'lokasi_tipe',

        'lokasi_id',

        'lokasi_nama',

        'jenis_kegiatan_id',

        'deskripsi',

        'status',

        'created_by'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
