<?php
namespace App\Models;

use CodeIgniter\Model;

class KoperasiPembelianModel extends Model
{
    protected $table = 'koperasi_pembelian';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'no_pembelian','belanja_id','id_sppg','tanggal_pembelian','supplier','supplier_id',
        'no_invoice_supplier','catatan','status','total','total_harga_beli','total_margin','margin_persen','created_by','updated_by',
        'dibeli_at','dibeli_by','dikirim_at','dikirim_by','created_at','updated_at'
    ];
    protected $useTimestamps = true;
}
