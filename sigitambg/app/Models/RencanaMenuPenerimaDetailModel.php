<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaMenuPenerimaDetailModel extends Model
{
    protected $table = 'rencana_menu_penerima_detail';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'rencana_menu_penerima_id',
        'menu_id',
        'nama_menu',
        'jenis_penggunaan',
        'target_porsi_besar',
        'target_porsi_kecil',
        'total_target',
        'catatan',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
