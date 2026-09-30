<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SelfBrandsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        $brands = DB::connection('pgsql_second')
            ->table('brands')
            ->leftJoin('prompts', 'prompts.userId', '=', 'brands.user_id')
            ->where('brands.is_self', 1)
            ->select(
                'brands.brand_name',
                'brands.domain',
                DB::raw('COUNT(prompts.id) as total_prompts')
            )
            ->groupBy('brands.id', 'brands.brand_name', 'brands.domain')
            ->get();

        return $brands->map(function ($brand) {
            $domain = $brand->domain;
            if ($domain) {
                $decoded = json_decode($domain, true);
                if (is_array($decoded)) {
                    $domain = implode(', ', $decoded);
                } else {
                    $domain = trim($domain, '[]"\'');
                }
            }
            return [
                'brand_name' => $brand->brand_name,
                'domain' => $domain,
                'total_prompts' => $brand->total_prompts,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Brand Name',
            'Domain',
            'Total Prompts',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Style headings (Row 1)
                $sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD'],
                    ],
                ]);

                // Border all cells
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A1:C{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}
