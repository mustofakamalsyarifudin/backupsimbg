<?php
namespace App\Models;
use CodeIgniter\Model;
class MasterJenisDokumenSupplierModel extends Model
{
    protected $table='master_jenis_dokumen_supplier'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['nama_jenis','status','keterangan','created_by','created_at','updated_at'];
    protected $useTimestamps=true;
}
