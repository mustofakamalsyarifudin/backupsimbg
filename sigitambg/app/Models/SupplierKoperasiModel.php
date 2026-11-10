<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierKoperasiModel extends Model
{
    protected $table = 'supplier_koperasi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'koperasi_id','id_sppg','tanggal','kode_supplier','nama_supplier','nama_pic','no_hp',
        'alamat','kabupaten_kota','provinsi','npwp_nik','email','tanggal_mou_mulai','tanggal_mou_akhir',
        'status','catatan','bank','nomor_rekening','kontrak_path','created_by','created_at','updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
