<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranAslapModel extends Model
{
    protected $table = 'pengeluaran_aslap';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'id_sppg',
        'tanggal',
        'kategori',
        'uraian',
        'nominal',
        'metode_pembayaran',
        'foto_bukti',
        'created_by'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
