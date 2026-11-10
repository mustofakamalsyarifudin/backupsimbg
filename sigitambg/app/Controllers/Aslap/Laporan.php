<?php

namespace App\Controllers\Aslap;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $idSppg = session('id_sppg');

        $tanggalAwal = $this->request->getGet(
            'tanggal_awal'
        );

        $tanggalAkhir = $this->request->getGet(
            'tanggal_akhir'
        );

        $data = [

            'tanggal_awal' => $tanggalAwal,

            'tanggal_akhir' => $tanggalAkhir,

            'laporan' => false

        ];

        if (
            !empty($tanggalAwal)
            &&
            !empty($tanggalAkhir)
        ) {

            $sppg = $db
                ->table('sppg')
                ->where(
                    'id_sppg',
                    $idSppg
                )
                ->get()
                ->getRowArray();

            /**
             * ============================================================
             * RINGKASAN PENERIMA MANFAAT PER JENJANG
             * ============================================================
             */
            $kategori = $db
                ->table('pm_jenjang j')
                ->select(
                    '
        j.jenjang,
        SUM(k.jumlah_siswa) AS total,
        SUM(k.jumlah_alergi) AS total_alergi
        '
                )
                ->join(
                    'pm_kelas k',
                    'k.jenjang_id = j.id',
                    'left'
                )
                ->join(
                    'penerima_manfaat p',
                    'p.id = j.pm_id',
                    'inner'
                )
                ->where(
                    'p.id_sppg',
                    $idSppg
                )
                ->groupBy(
                    'j.jenjang'
                )
                ->orderBy(
                    'j.jenjang',
                    'ASC'
                )
                ->get()
                ->getResultArray();

            $alergi = $db
                ->table('pm_kelas k')
                ->select(
                    '
                    p.sekolah_nama,
                    k.nama_kelas,
                    k.jumlah_alergi,
                    k.catatan_alergi
                    '
                )
                ->join(
                    'penerima_manfaat p',
                    'p.id = k.pm_id'
                )
                ->where(
                    'p.id_sppg',
                    $idSppg
                )
                ->where(
                    'k.jumlah_alergi >',
                    0
                )
                ->get()
                ->getResultArray();


            $kegiatan = $db
                ->table(
                    'kegiatan_aslap'
                )

                ->where(
                    'id_sppg',
                    $idSppg
                )

                ->where(
                    'tanggal >=',
                    $tanggalAwal
                )

                ->where(
                    'tanggal <=',
                    $tanggalAkhir
                )

                ->orderBy(
                    'tanggal',
                    'ASC'
                )

                ->get()

                ->getResultArray();

            foreach ($kegiatan as &$item) {

                $item['total_foto'] = $db

                    ->table(
                        'kegiatan_aslap_foto'
                    )

                    ->where(
                        'kegiatan_id',
                        $item['id']
                    )

                    ->countAllResults();
            }


            $pengeluaran = $db
                ->table('pengeluaran_aslap')
                ->where(
                    'id_sppg',
                    $idSppg
                )
                ->where(
                    'tanggal >=',
                    $tanggalAwal
                )
                ->where(
                    'tanggal <=',
                    $tanggalAkhir
                )
                ->orderBy(
                    'tanggal',
                    'DESC'
                )
                ->get()
                ->getResultArray();

            $totalPengeluaran = $db
                ->table('pengeluaran_aslap')
                ->selectSum(
                    'nominal'
                )
                ->where(
                    'id_sppg',
                    $idSppg
                )
                ->where(
                    'tanggal >=',
                    $tanggalAwal
                )
                ->where(
                    'tanggal <=',
                    $tanggalAkhir
                )
                ->get()
                ->getRowArray();

            $data = [

                'tanggal_awal' =>
                $tanggalAwal,

                'tanggal_akhir' =>
                $tanggalAkhir,

                'laporan' =>
                true,

                'sppg' =>
                $sppg,

                'kategori' =>
                $kategori,

                'alergi' =>
                $alergi,

                'kegiatan' =>
                $kegiatan,

                'pengeluaran' =>
                $pengeluaran,

                'totalPengeluaran' =>
                $totalPengeluaran['nominal']
                    ?? 0

            ];
        }

        return view(
            'aslap/laporan/index',
            $data
        );
    }

    public function exportExcel()
    {
        $db = \Config\Database::connect();

        $idSppg = session('id_sppg');

        $tanggalAwal =
            $this->request->getGet(
                'tanggal_awal'
            );

        $tanggalAkhir =
            $this->request->getGet(
                'tanggal_akhir'
            );

        $spreadsheet =
            new Spreadsheet();

        $setHeaderLaporan = function (
            $sheet,
            $sppgName,
            $tanggalAwal,
            $tanggalAkhir
        ) {

            $sheet->mergeCells('A1:F1');
            $sheet->mergeCells('A2:F2');

            $sheet->setCellValue(
                'A1',
                'LAPORAN ASISTEN LAPANGAN'
            );

            $sheet->setCellValue(
                'A2',
                strtoupper($sppgName)
            );

            $sheet->setCellValue(
                'A4',
                'Periode'
            );

            $sheet->setCellValue(
                'B4',
                date(
                    'd-m-Y',
                    strtotime($tanggalAwal)
                )
                    . ' s/d ' .
                    date(
                        'd-m-Y',
                        strtotime($tanggalAkhir)
                    )
            );

            $sheet->setCellValue(
                'A5',
                'Asisten Lapangan'
            );

            $sheet->setCellValue(
                'B5',
                session('full_name')
            );

            $sheet->setCellValue(
                'A6',
                'Tanggal Cetak'
            );

            $sheet->setCellValue(
                'B6',
                date('d-m-Y H:i')
            );

            $sheet->getStyle(
                'A1'
            )->getFont()
                ->setBold(true)
                ->setSize(16);

            $sheet->getStyle(
                'A2'
            )->getFont()
                ->setBold(true)
                ->setSize(13);

            $sheet->getStyle(
                'A1:F2'
            )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );

            $sheet->getStyle(
                'A4:B6'
            )
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );
        };

        $sheet =
            $spreadsheet->getActiveSheet();

        $sheet->setTitle(
            'Ringkasan PM'
        );

        $sppg = $db
            ->table('sppg')
            ->where(
                'id_sppg',
                $idSppg
            )
            ->get()
            ->getRowArray();

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        $sheet->setCellValue(
            'A1',
            'LAPORAN ASISTEN LAPANGAN'
        );

        $sheet->setCellValue(
            'A2',
            strtoupper(
                $sppg['sppg_name']
            )
        );

        $sheet->setCellValue(
            'A4',
            'Periode'
        );

        $sheet->setCellValue(
            'B4',
            date(
                'd-m-Y',
                strtotime($tanggalAwal)
            )
                . ' s/d ' .
                date(
                    'd-m-Y',
                    strtotime($tanggalAkhir)
                )
        );

        $sheet->setCellValue(
            'A5',
            'Asisten Lapangan'
        );

        $sheet->setCellValue(
            'B5',
            session('full_name')
        );

        $sheet->setCellValue(
            'A6',
            'Tanggal Cetak'
        );

        $sheet->setCellValue(
            'B6',
            date('d-m-Y H:i')
        );
        $sheet->getStyle(
            'A4:B6'
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet->setCellValue(
            'A8',
            'Jenjang'
        );

        $sheet->setCellValue(
            'B8',
            'Jumlah'
        );

        $sheet->setCellValue(
            'C8',
            'Alergi'
        );


        /**
         * ============================================================
         * RINGKASAN PENERIMA MANFAAT PER JENJANG
         * ============================================================
         */
        $kategori = $db
            ->table('pm_jenjang j')
            ->select(
                '
                    j.jenjang,
                    SUM(k.jumlah_siswa) AS total,
                    SUM(k.jumlah_alergi) AS total_alergi
                    '
            )
            ->join(
                'pm_kelas k',
                'k.jenjang_id = j.id',
                'left'
            )
            ->join(
                'penerima_manfaat p',
                'p.id = j.pm_id',
                'inner'
            )
            ->where(
                'p.id_sppg',
                $idSppg
            )
            ->groupBy(
                'j.jenjang'
            )
            ->orderBy(
                'j.jenjang',
                'ASC'
            )
            ->get()
            ->getResultArray();


        $row = 9;

        foreach ($kategori as $item) {

            $sheet->setCellValue(
                'A' . $row,
                $item['jenjang']
            );

            $sheet->setCellValue(
                'B' . $row,
                (int) ($item['total'] ?? 0)
            );

            $sheet->setCellValue(
                'C' . $row,
                (int) ($item['total_alergi'] ?? 0)
            );

            $row++;
        }

        $lastRow = $row - 1;

        $sheet->getStyle(
            'A8:C8'
        )->getFont()->setBold(true);

        $sheet->getStyle(
            'A8:C8'
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'B4C6E7'
            );

        $sheet->getStyle(
            'A8:C' . $lastRow
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet->getStyle(
            'A1'
        )->getFont()
            ->setBold(true)
            ->setSize(16);

        $sheet->getStyle(
            'A2'
        )->getFont()
            ->setBold(true)
            ->setSize(13);

        $sheet->getStyle(
            'A1:C2'
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );

        $sheet->getStyle(
            'B9:C' . $lastRow
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            );

        $sheet->getStyle(
            'B9:C' . $lastRow
        )
            ->getNumberFormat()
            ->setFormatCode(
                '#,##0'
            );


        $sheet->setCellValue(
            'A' . ($lastRow + 2),
            'TOTAL PM'
        );

        $sheet->setCellValue(
            'B' . ($lastRow + 2),
            '=SUM(B9:B' . $lastRow . ')'
        );

        $sheet->setCellValue(
            'A' . ($lastRow + 3),
            'TOTAL ALERGI'
        );

        $sheet->setCellValue(
            'B' . ($lastRow + 3),
            '=SUM(C9:C' . $lastRow . ')'
        );

        $sheet->getStyle(
            'A' . ($lastRow + 2) .
                ':B' . ($lastRow + 3)
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'FFF2CC'
            );

        $sheet->getStyle(
            'A' . ($lastRow + 2) .
                ':B' . ($lastRow + 3)
        )
            ->getFont()
            ->setBold(true);

        $sheet->getStyle(
            'B' . ($lastRow + 2) .
                ':B' . ($lastRow + 3)
        )
            ->getNumberFormat()
            ->setFormatCode(
                '#,##0'
            );

        $sheet->getStyle(
            'A' . ($lastRow + 2) .
                ':B' . ($lastRow + 3)
        )->getFont()->setBold(true);
        $sheet->getStyle(
            'A' . ($lastRow + 2) .
                ':B' . ($lastRow + 3)
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );






        $sheet2 =
            $spreadsheet
            ->createSheet();

        $sheet2->setTitle(
            'Data Alergi'
        );

        $setHeaderLaporan(
            $sheet2,
            $sppg['sppg_name'],
            $tanggalAwal,
            $tanggalAkhir
        );

        $sheet2->setCellValue(
            'A8',
            'Sekolah'
        );

        $sheet2->setCellValue(
            'B8',
            'Kelas'
        );

        $sheet2->setCellValue(
            'C8',
            'Jumlah Alergi'
        );

        $sheet2->setCellValue(
            'D8',
            'Catatan'
        );

        $alergi = $db
            ->table('pm_kelas k')

            ->select(
                '
            p.sekolah_nama,
            k.nama_kelas,
            k.jumlah_alergi,
            k.catatan_alergi
            '
            )

            ->join(
                'penerima_manfaat p',
                'p.id=k.pm_id'
            )

            ->where(
                'p.id_sppg',
                $idSppg
            )

            ->where(
                'k.jumlah_alergi >',
                0
            )

            ->get()

            ->getResultArray();

        $row = 9;

        foreach ($alergi as $item) {

            $sheet2->setCellValue(
                'A' . $row,
                $item['sekolah_nama']
            );

            $sheet2->setCellValue(
                'B' . $row,
                $item['nama_kelas']
            );

            $sheet2->setCellValue(
                'C' . $row,
                $item['jumlah_alergi']
            );

            $sheet2->setCellValue(
                'D' . $row,
                $item['catatan_alergi']
            );

            $row++;
        }

        $lastRowAlergi = $row - 1;

        $sheet2->getStyle(
            'A8:D8'
        )->getFont()->setBold(true);

        $sheet2->getStyle(
            'A8:D8'
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'B4C6E7'
            );

        $sheet2->getStyle(
            'D9:D' . $lastRowAlergi
        )
            ->getAlignment()
            ->setWrapText(true);

        $sheet2->getStyle(
            'A8:D' . $lastRowAlergi
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet2->getStyle(
            'C9:C' . $lastRowAlergi
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            );

        $sheet2->getStyle(
            'C9:C' . $lastRowAlergi
        )
            ->getNumberFormat()
            ->setFormatCode(
                '#,##0'
            );





        $sheet3 =
            $spreadsheet
            ->createSheet();

        $sheet3->setTitle(
            'Kegiatan'
        );

        $setHeaderLaporan(
            $sheet3,
            $sppg['sppg_name'],
            $tanggalAwal,
            $tanggalAkhir
        );

        $sheet3->setCellValue(
            'A8',
            'Tanggal'
        );

        $sheet3->setCellValue(
            'B8',
            'Judul Kegiatan'
        );

        $sheet3->setCellValue(
            'C8',
            'Lokasi'
        );

        $sheet3->setCellValue(
            'D8',
            'Deskripsi'
        );

        $kegiatan = $db
            ->table(
                'kegiatan_aslap'
            )

            ->where(
                'id_sppg',
                $idSppg
            )

            ->where(
                'tanggal >=',
                $tanggalAwal
            )

            ->where(
                'tanggal <=',
                $tanggalAkhir
            )

            ->get()

            ->getResultArray();

        $row = 9;

        foreach ($kegiatan as $item) {

            $sheet3->setCellValue(
                'A' . $row,
                date(
                    'd-m-Y',
                    strtotime(
                        $item['tanggal']
                    )
                )
            );
            $sheet3->setCellValue(
                'B' . $row,
                $item['judul_kegiatan']
            );

            $sheet3->setCellValue(
                'C' . $row,
                $item['lokasi']
            );

            $sheet3->setCellValue(
                'D' . $row,
                $item['deskripsi']
            );

            $row++;
        }

        $lastRowKegiatan = $row - 1;

        $sheet3->mergeCells(
            'A' . ($lastRowKegiatan + 2) .
                ':B' . ($lastRowKegiatan + 2)
        );

        $sheet3->getStyle(
            'A8:D8'
        )->getFont()->setBold(true);

        $sheet3->getStyle(
            'A8:D8'
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'B4C6E7'
            );

        $sheet3->getStyle(
            'A8:D' . $lastRowKegiatan
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );


        $sheet3->getStyle(
            'A9:A' . $lastRowKegiatan
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );
        $sheet3->setCellValue(
            'A' . ($lastRowKegiatan + 2),
            'JUMLAH KEGIATAN'
        );

        $sheet3->setCellValue(
            'C' . ($lastRowKegiatan + 2),
            count($kegiatan)
        );

        $sheet3->getStyle(
            'A' . ($lastRowKegiatan + 2) .
                ':C' . ($lastRowKegiatan + 2)
        )
            ->getFont()
            ->setBold(true);

        $sheet3->getStyle(
            'A' . ($lastRowKegiatan + 2) .
                ':C' . ($lastRowKegiatan + 2)
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'FFF2CC'
            );





        $sheet4 =
            $spreadsheet
            ->createSheet();

        $sheet4->setTitle(
            'Pengeluaran'
        );

        $setHeaderLaporan(
            $sheet4,
            $sppg['sppg_name'],
            $tanggalAwal,
            $tanggalAkhir
        );
        $sheet4->setCellValue(
            'A8',
            'Tanggal'
        );

        $sheet4->setCellValue(
            'B8',
            'Kategori'
        );

        $sheet4->setCellValue(
            'C8',
            'Uraian'
        );

        $sheet4->setCellValue(
            'D8',
            'Metode'
        );

        $sheet4->setCellValue(
            'E8',
            'Nominal'
        );

        $sheet4->setCellValue(
            'F8',
            'Bukti'
        );

        $pengeluaran = $db
            ->table(
                'pengeluaran_aslap'
            )

            ->where(
                'id_sppg',
                $idSppg
            )

            ->where(
                'tanggal >=',
                $tanggalAwal
            )

            ->where(
                'tanggal <=',
                $tanggalAkhir
            )

            ->get()

            ->getResultArray();

        $row = 9;

        foreach ($pengeluaran as $item) {

            $sheet4->setCellValue(
                'A' . $row,
                date(
                    'd-m-Y',
                    strtotime(
                        $item['tanggal']
                    )
                )
            );

            $sheet4->setCellValue(
                'B' . $row,
                $item['kategori']
            );

            $sheet4->setCellValue(
                'C' . $row,
                $item['uraian']
            );

            $sheet4->setCellValue(
                'D' . $row,
                $item['metode_pembayaran']
            );

            $sheet4->setCellValue(
                'E' . $row,
                $item['nominal']
            );

            $sheet4->setCellValue(
                'F' . $row,
                empty($item['foto_bukti'])
                    ? '✗ Tidak Ada'
                    : '✓ Ada'
            );

            $row++;
        }

        $lastRowPengeluaran = $row - 1;

        $sheet4->getStyle(
            'A8:F8'
        )->getFont()->setBold(true);

        $sheet4->getStyle(
            'A8:F8'
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'B4C6E7'
            );

        $sheet4->getStyle(
            'A8:F' . $lastRowPengeluaran
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet4->getStyle(
            'E9:E' . $lastRowPengeluaran
        )
            ->getNumberFormat()
            ->setFormatCode(
                '"Rp " #,##0'
            );

        $sheet4->getStyle(
            'E9:E' . $lastRowPengeluaran
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            );


        $sheet4->setCellValue(
            'D' . ($lastRowPengeluaran + 2),
            'TOTAL PENGELUARAN'
        );

        $sheet4->setCellValue(
            'E' . ($lastRowPengeluaran + 2),
            '=SUM(E9:E' . $lastRowPengeluaran . ')'
        );

        $sheet4->getStyle(
            'D' . ($lastRowPengeluaran + 2) .
                ':E' . ($lastRowPengeluaran + 2)
        )
            ->getFont()
            ->setBold(true);

        $sheet4->getStyle(
            'D' . ($lastRowPengeluaran + 2) .
                ':E' . ($lastRowPengeluaran + 2)
        )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB(
                'FFF2CC'
            );

        $sheet4->getStyle(
            'E' . ($lastRowPengeluaran + 2)
        )
            ->getNumberFormat()
            ->setFormatCode(
                '"Rp " #,##0'
            );

        foreach ($spreadsheet->getAllSheets()
            as $sheet) {

            foreach (range('A', 'Z')
                as $col) {

                $sheet
                    ->getColumnDimension(
                        $col
                    )

                    ->setAutoSize(
                        true
                    );
            }
        }


        $filename =
            'Laporan_Aslap_' .
            $tanggalAwal .
            '_' .
            $tanggalAkhir .
            '.xlsx';

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="' .
                $filename .
                '"'
        );

        header(
            'Cache-Control: max-age=0'
        );

        $writer =
            new Xlsx(
                $spreadsheet
            );

        $writer->save(
            'php://output'
        );

        exit;
    }

    /**
     * ============================================================
     * EXPORT PDF
     * ============================================================
     */
    public function exportPdf()
    {
        $db = \Config\Database::connect();

        $idSppg = session('id_sppg');

        $tanggalAwal = $this->request->getGet(
            'tanggal_awal'
        );

        $tanggalAkhir = $this->request->getGet(
            'tanggal_akhir'
        );

        /**
         * --------------------------------------------------------
         * DATA SPPG
         * --------------------------------------------------------
         */
        $sppg = $db
            ->table('sppg')
            ->where(
                'id_sppg',
                $idSppg
            )
            ->get()
            ->getRowArray();


        /**
         * --------------------------------------------------------
         * RINGKASAN PENERIMA MANFAAT PER JENJANG
         * --------------------------------------------------------
         */
        $kategori = $db
            ->table('pm_jenjang j')
            ->select(
                '
            j.jenjang,
            SUM(k.jumlah_siswa) AS total,
            SUM(k.jumlah_alergi) AS total_alergi
            '
            )
            ->join(
                'pm_kelas k',
                'k.jenjang_id = j.id',
                'left'
            )
            ->join(
                'penerima_manfaat p',
                'p.id = j.pm_id',
                'inner'
            )
            ->where(
                'p.id_sppg',
                $idSppg
            )
            ->groupBy(
                'j.jenjang'
            )
            ->orderBy(
                'j.jenjang',
                'ASC'
            )
            ->get()
            ->getResultArray();


        /**
         * --------------------------------------------------------
         * DATA ALERGI
         * --------------------------------------------------------
         */
        $alergi = $db
            ->table('pm_kelas k')
            ->select(
                '
            p.sekolah_nama,
            pm_jenjang.jenjang,
            k.nama_kelas,
            k.jumlah_alergi,
            k.catatan_alergi
            '
            )
            ->join(
                'penerima_manfaat p',
                'p.id = k.pm_id'
            )
            ->join(
                'pm_jenjang',
                'pm_jenjang.id = k.jenjang_id',
                'left'
            )
            ->where(
                'p.id_sppg',
                $idSppg
            )
            ->where(
                'k.jumlah_alergi >',
                0
            )
            ->orderBy(
                'p.sekolah_nama',
                'ASC'
            )
            ->get()
            ->getResultArray();


        /**
         * --------------------------------------------------------
         * DATA KEGIATAN
         * --------------------------------------------------------
         */
        $kegiatan = $db
            ->table('kegiatan_aslap')
            ->where(
                'id_sppg',
                $idSppg
            )
            ->where(
                'tanggal >=',
                $tanggalAwal
            )
            ->where(
                'tanggal <=',
                $tanggalAkhir
            )
            ->orderBy(
                'tanggal',
                'ASC'
            )
            ->get()
            ->getResultArray();


        /**
         * --------------------------------------------------------
         * DATA PENGELUARAN
         * --------------------------------------------------------
         */
        $pengeluaran = $db
            ->table('pengeluaran_aslap')
            ->where(
                'id_sppg',
                $idSppg
            )
            ->where(
                'tanggal >=',
                $tanggalAwal
            )
            ->where(
                'tanggal <=',
                $tanggalAkhir
            )
            ->orderBy(
                'tanggal',
                'ASC'
            )
            ->get()
            ->getResultArray();


        /**
         * --------------------------------------------------------
         * TOTAL PENGELUARAN
         * --------------------------------------------------------
         */
        $totalPengeluaran = $db
            ->table('pengeluaran_aslap')
            ->selectSum(
                'nominal'
            )
            ->where(
                'id_sppg',
                $idSppg
            )
            ->where(
                'tanggal >=',
                $tanggalAwal
            )
            ->where(
                'tanggal <=',
                $tanggalAkhir
            )
            ->get()
            ->getRowArray();


        /**
         * --------------------------------------------------------
         * DATA PDF
         * --------------------------------------------------------
         */
        $data = [

            'sppg' =>
            $sppg,

            'kategori' =>
            $kategori,

            'tanggal_awal' =>
            $tanggalAwal,

            'tanggal_akhir' =>
            $tanggalAkhir,

            'alergi' =>
            $alergi,

            'kegiatan' =>
            $kegiatan,

            'pengeluaran' =>
            $pengeluaran,

            'totalPengeluaran' =>
            (int) ($totalPengeluaran['nominal']
                ?? 0
            )

        ];


        /**
         * --------------------------------------------------------
         * GENERATE PDF
         * --------------------------------------------------------
         */
        $options = new Options();

        $options->set(
            'isRemoteEnabled',
            true
        );

        $dompdf = new Dompdf(
            $options
        );

        $html = view(
            'aslap/laporan/pdf',
            $data
        );

        $dompdf->loadHtml(
            $html
        );

        $dompdf->setPaper(
            'A4',
            'portrait'
        );

        $dompdf->render();

        $dompdf->stream(
            'laporan-aslap-' .
                $tanggalAwal .
                '-' .
                $tanggalAkhir .
                '.pdf',
            [
                'Attachment' => false
            ]
        );

        exit;
    }
}
