<?php
namespace App\Models;

use CodeIgniter\Model;

class KoperasiPembelianDetailModel extends Model
{
    protected $table = 'koperasi_pembelian_detail';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pembelian_id','bahan_id','supplier_bahan_id','nama_bahan','qty_diminta','qty_dibeli',
        'satuan','harga_satuan','harga_beli_snapshot','harga_jual_snapshot','margin_snapshot',
        'margin_persen_snapshot','total_harga','no_invoice_supplier','keterangan','created_at','updated_at'
    ];
    protected $useTimestamps = true;
}
