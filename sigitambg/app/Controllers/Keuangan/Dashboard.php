<?php
namespace App\Controllers\Keuangan;
use App\Models\BahanBakuModel;
use App\Models\PengeluaranAslapModel;
class Dashboard extends BaseKeuangan
{
 public function index(){if($r=$this->ensureKeuangan())return $r;$id=session('id_sppg');$m=new BahanBakuModel();$e=new PengeluaranAslapModel();$data=['sppg_name'=>$this->sppgName(),'waiting_finance'=>$m->where('id_sppg',$id)->where('status','waiting_finance')->countAllResults(),'waiting_kepala'=>$m->where('id_sppg',$id)->where('status','waiting_kepala')->countAllResults(),'waiting_koperasi'=>$m->where('id_sppg',$id)->where('status','waiting_koperasi')->countAllResults(),'total_pengeluaran'=>(float) ($e->where('id_sppg',$id)->selectSum('nominal')->first()['nominal'] ?? 0),'total_pengajuan'=>$m->where('id_sppg',$id)->countAllResults()];return view('dashboard/keuangan',$data);}
}
