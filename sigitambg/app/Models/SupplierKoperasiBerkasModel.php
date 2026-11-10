<?php
namespace App\Models;
use CodeIgniter\Model;
class SupplierKoperasiBerkasModel extends Model
{
    protected $table='supplier_koperasi_berkas'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['supplier_id','jenis_dokumen_id','nama_berkas','file_name','file_path','file_type','file_size','keterangan','created_by','created_at','updated_at'];
    protected $useTimestamps=true;
}
