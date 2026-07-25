<?php

namespace App\Exports;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\{
    FromArray, WithHeadings, WithStyles, WithEvents
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CutiExport implements FromArray, WithHeadings, WithStyles, WithEvents
{
    protected $cutis;
    protected $rekap;
    protected $departemenNama;

    public function __construct($cutis, $rekap, $departemenNama)
    {
        $this->cutis = $cutis;
        $this->rekap = $rekap;
        $this->departemenNama = $departemenNama;
    }

    public function array(): array
    {
        $data = [];

        // Data tabel utama
        foreach ($this->cutis as $c) {
            $data[] = [
                $c->karyawan->user->nama,
                $c->karyawan->departemen->nama_departemen,
                $c->jeniscuti->nama_jenis,
                $c->tanggal_mulai,
                $c->tanggal_selesai,
                $c->jumlah_hari,
                ucfirst($c->status),
                $c->disetujuiOleh->nama ?? '-',
                $c->tanggal_disetujui ?? '-',
            ];
        }

        // Tambahkan rekap
        $data[] = [];
        $data[] = ["REKAPITULASI"];
        $data[] = ["Total Pengajuan", $this->rekap['total']];
        $data[] = ["Disetujui", $this->rekap['disetujui']];
        $data[] = ["Pending", $this->rekap['pending']];
        $data[] = ["Ditolak", $this->rekap['ditolak']];

        return $data;
    }

    public function headings(): array
    {
        return [
            "Nama Karyawan",
            "Departemen",
            "Jenis Cuti",
            "Tanggal Mulai",
            "Tanggal Selesai",
            "Jumlah Hari",
            "Status",
            "Disetujui Oleh",
            "Tanggal Disetujui",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Judul Besar
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', "LAPORAN CUTI - {$this->departemenNama}");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Heading tabel di baris ke-2
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {

                $sheet = $event->sheet->getDelegate();

                // Hitung batas baris data cuti
                $totalData = count($this->cutis);
                $headingRow = 2;
                $dataStart = 3;
                $dataEnd = $dataStart + $totalData - 1;

                // Border tabel utama
                if ($totalData > 0) {
                    $sheet->getStyle("A{$headingRow}:I{$dataEnd}")
                          ->getBorders()->getAllBorders()
                          ->setBorderStyle(Border::BORDER_THIN);
                }

                // Auto size
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Mulai blok rekap
                $rekapStart = $dataEnd + 2; // baris kosong + REKAPITULASI title

                // Border rekap
                $sheet->getStyle("A{$rekapStart}:B" . ($rekapStart + 4))
                      ->getBorders()->getAllBorders()
                      ->setBorderStyle(Border::BORDER_THIN);

                // Bold judul rekap
                $sheet->getStyle("A{$rekapStart}")->getFont()->setBold(true);
            }
        ];
    }
}
