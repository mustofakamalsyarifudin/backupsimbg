<?php
namespace App\Models;
use CodeIgniter\Model;
class SupplierBahanModel extends Model
{
    protected $table='supplier_bahan'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['supplier_id','bahan_id','harga_beli','minimum_order','status','keterangan','created_by','updated_by','created_at','updated_at'];
    protected $useTimestamps=true;
}
