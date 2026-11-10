<?php

namespace App\Models;

use CodeIgniter\Model;

class PMJenjangModel extends Model
{
    protected $table = 'pm_jenjang';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'pm_id',
        'jenjang'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
