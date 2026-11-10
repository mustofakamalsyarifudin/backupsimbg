<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBakuModel extends Model
{
    protected $table = 'bahan_baku';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'kode_transaksi',
        'id_sppg',
        'tanggal',
        'status',
        'catatan_keuangan',
        'foto_struk',
        'created_by',
        'approved_by',
        'approved_at',
        'catatan_approval',
        'finance_reviewed_by',
        'finance_reviewed_at',
        'kepala_approved_by',
        'kepala_approved_at',
        'koperasi_processed_by',
        'koperasi_processed_at',
        'koperasi_note',
        'pagu_tanggal',
        'pagu_porsi_kecil',
        'pagu_porsi_besar',
        'pagu_tarif_kecil',
        'pagu_tarif_besar',
        'pagu_total',
        'pagu_selisih',
        'pagu_snapshot_at'
    ];

    protected $useTimestamps = true;
}
