<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaManfaatModel extends Model
{
    protected $table = 'penerima_manfaat';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'id_sppg',

        'sekolah_nama',
        'sekolah_alamat',

        'kategori',
        'sub_kategori',

        'porsi_besar',
        'porsi_kecil',

        'total_siswa',

        'created_by'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
