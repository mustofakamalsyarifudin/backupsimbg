<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanGiziFotoModel extends Model
{
    protected $table = 'kegiatan_gizi_foto';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'kegiatan_id',

        'foto',

        'urutan'

    ];

    protected $useTimestamps = false;
}
