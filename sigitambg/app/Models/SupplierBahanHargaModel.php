<?php
namespace App\Models;
use CodeIgniter\Model;
class SupplierBahanHargaModel extends Model
{
    protected $table='supplier_bahan_harga'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['supplier_bahan_id','harga_lama','harga_baru','berlaku_mulai','diubah_oleh','keterangan','created_at'];
    protected $useTimestamps=false;
}
