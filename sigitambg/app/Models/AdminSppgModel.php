<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminSppgModel extends Model
{
    protected $table = 'admin_sppg';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'id_sppg', 'status'];
}
