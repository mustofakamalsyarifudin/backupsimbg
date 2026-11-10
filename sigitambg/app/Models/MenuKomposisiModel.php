<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuKomposisiModel extends Model
{
    protected $table = 'menu_komposisi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'menu_id',
        'jenis',
        'nama_item',
    ];

    protected $useTimestamps = false;
}
