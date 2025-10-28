<?php

namespace App\Exports;

use App\Material;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StockExport implements FromView, WithEvents, WithDrawings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $materials = Material::with(['rack', 'valves', 'sparePart', 'incomings', 'outgoings', 'stockOpnameLatest'])
            ->get()
            ->map(function ($item) {
                $qty_in = optional($item->incomings)->sum('qty_in') ?? 0;
                $qty_out = optional($item->outgoings)->sum('qty_out') ?? 0;
                $stock_akhir = $item->stock_awal + $qty_in - $qty_out;
                $opname = optional($item->stockOpnameLatest)->stock_actual;
                $selisih = $opname !== null ? $opname - $stock_akhir : null;

                return [
                    'material' => $item,
                    'qty_in' => $qty_in,
                    'qty_out' => $qty_out,
                    'stock_akhir' => $stock_akhir,
                    'opname' => $opname,
                    'selisih' => $selisih,
                    'balance' => $stock_akhir - $item->stock_minimum,
                    'warning' => $stock_akhir < $item->stock_minimum ? 'Below Minimum Stock' : '-'
                ];
            });

        // Filter bulan & tahun
        if ($this->bulan) {
            $materials = $materials->filter(fn($item) => Carbon::parse($item['material']->created_at)->format('m') === $this->bulan);
        }
        if ($this->tahun) {
            $materials = $materials->filter(fn($item) => Carbon::parse($item['material']->created_at)->format('Y') === $this->tahun);
        }

        return view('pages.admin.inventory.report.export.stock-excel', [
            'materials' => $materials,
            'bulan' => Carbon::create()->month($this->bulan)->locale('id')->translatedFormat('F'),
            'tahun' => $this->tahun
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // --- Atur lebar kolom ---
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(25);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(12);
                $sheet->getColumnDimension('H')->setWidth(12);
                $sheet->getColumnDimension('I')->setWidth(12);
                $sheet->getColumnDimension('J')->setWidth(12);
                $sheet->getColumnDimension('K')->setWidth(20);
                $sheet->getColumnDimension('L')->setWidth(12);
                $sheet->getColumnDimension('M')->setWidth(20);
                $sheet->getColumnDimension('N')->setWidth(20);
                $sheet->getColumnDimension('O')->setWidth(12);
                $sheet->getColumnDimension('P')->setWidth(20);

                // --- Rata tengah semua kolom ---
                $sheet->getStyle('A1:P' . $sheet->getHighestRow())
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // --- Tambahkan border ke seluruh tabel ---
                $sheet->getStyle('A1:P' . $sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('000000'));
            },
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('images/metinca-logo.jpeg')); // lokasi logo yg benar
        $drawing->setHeight(45);
        $drawing->setCoordinates('B1'); // posisi logo di Excel

        return [$drawing];
    }
}
