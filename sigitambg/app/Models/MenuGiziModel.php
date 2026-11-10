<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuGiziModel extends Model
{
    protected $table = 'menu_gizi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_sppg',
        'nama_menu',
        'kategori',
        'foto_menu',
        'catatan',
        'menu_induk_id',
        'is_varian',
        'created_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
