<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanAslapFotoModel extends Model
{
    protected $table = 'kegiatan_aslap_foto';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'kegiatan_id',
        'foto'

    ];

    protected $useTimestamps = false;
}
