<?php

namespace App\Models;

use CodeIgniter\Model;

class SppgModel extends Model
{
    protected $table = 'sppg';
    protected $primaryKey = 'id_sppg';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_sppg',
        'sppg_name',
        'address',
        'phone',
        'email',
        'established_date',
        'status',
    ];
}
