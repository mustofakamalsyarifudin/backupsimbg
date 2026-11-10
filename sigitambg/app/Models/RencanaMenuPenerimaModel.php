<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaMenuPenerimaModel extends Model
{
    protected $table = 'rencana_menu_penerima';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'rencana_menu_id',
        'pm_id',
        'sekolah_nama',
        'kategori',
        'sub_kategori',
        'porsi_besar',
        'porsi_kecil',
        'total_pm',
        'jumlah_alergi',
        'catatan_alergi',
        'catatan',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
