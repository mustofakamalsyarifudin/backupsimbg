<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaMenuDetailModel extends Model
{
    protected $table = 'rencana_menu_detail';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'rencana_menu_id',
        'menu_id',
        'jenis_penggunaan',
        'catatan',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
