<?php

namespace App\Exports;

use App\Models\Screenshot;
use App\Models\EmployeeDailyActivity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeActivityExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $employeeId;
    protected $date;
    protected $screenshotHeaderRow = 0;

    public function __construct($employeeId, $date)
    {
        $this->employeeId = $employeeId;
        $this->date = $date;
    }

    private function formatSeconds($seconds)
    {
        if (!$seconds || $seconds <= 0) {
            return '0m';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";
    }

    public function collection()
    {
        $rows = collect();

        $screenshots = Screenshot::where('employee_id', $this->employeeId)
            ->whereDate('date_time', $this->date)
            ->get();

        $dailyActivity = EmployeeDailyActivity::where('employee_id', $this->employeeId)
            ->where('activity_date', $this->date)
            ->first();

        $rows->push(['Label' => 'Date', 'Value' => $this->date]);
        $rows->push(['Label' => '', 'Value' => '']);

        $rows->push(['Label' => 'Total Time', 'Value' => $this->formatSeconds($dailyActivity->total_seconds ?? 0)]);
        $rows->push(['Label' => 'Active Time', 'Value' => $this->formatSeconds($dailyActivity->active_seconds ?? 0)]);
        $rows->push(['Label' => 'Idle Time', 'Value' => $this->formatSeconds($dailyActivity->idle_seconds ?? 0)]);

        $rows->push(['Label' => '', 'Value' => '']);

        $this->screenshotHeaderRow = $rows->count() + 2;

        $rows->push([
            'Label' => 'Screenshot URL',
            'Value' => 'Captured At',
        ]);

        foreach ($screenshots as $shot) {
            $rows->push([
                'Label' => asset($shot->screenshot_path),
                'Value' => $shot->date_time,
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Label', 'Value'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:B1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9E1F2'],
                    ],
                ]);

                $row = $this->screenshotHeaderRow;

                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'BDD7EE'],
                    ],
                ]);

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A1:B{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle("A1:A{$lastRow}")
                    ->getAlignment()
                    ->setWrapText(true);

                for ($i = $row + 1; $i <= $lastRow; $i++) {

                    $url = $sheet->getCell("A{$i}")->getValue();

                    if ($url) {
                        $sheet->getCell("A{$i}")
                            ->getHyperlink()
                            ->setUrl($url);

                        $sheet->getStyle("A{$i}")
                            ->getFont()
                            ->getColor()
                            ->setRGB('0000FF');

                        $sheet->getStyle("A{$i}")
                            ->getFont()
                            ->setUnderline(true);
                    }
                }
            },
        ];
    }
}