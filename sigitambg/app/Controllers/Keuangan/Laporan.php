<?php
namespace App\Controllers\Keuangan;

use App\Models\BahanBakuModel;
use App\Models\BahanBakuDetailModel;
use App\Models\PengeluaranAslapModel;
use App\Models\SppgModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseKeuangan
{
    public function index()
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;
        $from = trim((string)$this->request->getGet('from'));
        $to = trim((string)$this->request->getGet('to'));
        $purchase = (new BahanBakuModel())->where('id_sppg',session('id_sppg'));
        if ($from !== '') $purchase->where('tanggal >=',$from);
        if ($to !== '') $purchase->where('tanggal <=',$to);
        $purchases = $purchase->orderBy('tanggal','DESC')->findAll();
        $detail = new BahanBakuDetailModel();
        foreach($purchases as &$r){ $x=$detail->selectSum('total_harga')->where('belanja_id',$r['id'])->first(); $r['grand_total']=(float)($x['total_harga']??0); }
        $exp=(new PengeluaranAslapModel())->where('id_sppg',session('id_sppg'));
        if($from!=='')$exp->where('tanggal >=',$from); if($to!=='')$exp->where('tanggal <=',$to);
        $expenses=$exp->orderBy('tanggal','DESC')->findAll();
        $cashBuilder = \Config\Database::connect()->table('petty_cash')->where('id_sppg', session('id_sppg'));
        if ($from !== '') $cashBuilder->where('tanggal >=', $from);
        if ($to !== '') $cashBuilder->where('tanggal <=', $to);
        $pettyCash = $cashBuilder->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC')->get()->getResultArray();
        $cashSummary = ['masuk' => 0.0, 'keluar' => 0.0];
        foreach ($pettyCash as $cash) { if ($cash['jenis'] === 'pemasukan') $cashSummary['masuk'] += (float)$cash['jumlah']; else $cashSummary['keluar'] += (float)$cash['jumlah']; }
        return view('keuangan/laporan',['purchases'=>$purchases,'expenses'=>$expenses,'petty_cash'=>$pettyCash,'cash_summary'=>$cashSummary,'from'=>$from,'to'=>$to,'sppg_name'=>$this->sppgName()]);
    }

    public function pdf()
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;
        $from=trim((string)$this->request->getGet('from')); $to=trim((string)$this->request->getGet('to'));
        $purchase=(new BahanBakuModel())->where('id_sppg',session('id_sppg'));
        if($from!=='')$purchase->where('tanggal >=',$from); if($to!=='')$purchase->where('tanggal <=',$to);
        $purchases=$purchase->orderBy('tanggal','DESC')->findAll(); $detail=new BahanBakuDetailModel();
        foreach($purchases as &$r){$x=$detail->selectSum('total_harga')->where('belanja_id',$r['id'])->first();$r['grand_total']=(float)($x['total_harga']??0);}
        $exp=(new PengeluaranAslapModel())->where('id_sppg',session('id_sppg'));
        if($from!=='')$exp->where('tanggal >=',$from); if($to!=='')$exp->where('tanggal <=',$to); $expenses=$exp->orderBy('tanggal','DESC')->findAll();
        $cashBuilder = \Config\Database::connect()->table('petty_cash')->where('id_sppg', session('id_sppg'));
        if ($from !== '') $cashBuilder->where('tanggal >=', $from);
        if ($to !== '') $cashBuilder->where('tanggal <=', $to);
        $pettyCash = $cashBuilder->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC')->get()->getResultArray();
        $sppg=(new SppgModel())->where('id_sppg',session('id_sppg'))->first();
        $html=view('keuangan/laporan_pdf',['purchases'=>$purchases,'expenses'=>$expenses,'petty_cash'=>$pettyCash,'from'=>$from,'to'=>$to,'sppg_name'=>$sppg['sppg_name']??session('id_sppg')]);
        $opt=new Options();$opt->set('isRemoteEnabled',true);$dompdf=new Dompdf($opt);$dompdf->loadHtml($html);$dompdf->setPaper('A4','portrait');$dompdf->render();$dompdf->stream('laporan-keuangan-'.date('Ymd-His').'.pdf',['Attachment'=>true]);exit;
    }
}
