<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TabelExport implements FromArray,WithHeadings,WithStyles,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $cadries;
    protected $count;
    protected $itemcount;

    public function __construct($cadries, $itemcount, $count)
    {
        $this->cadries = $cadries;
        $this->count = $count;
        $this->itemcount = $itemcount;
    }
    
    // public function view(): View
    // {
    //     set_time_limit(1000);
        
    //     return view('export.tabel', [

    //     ]);
    // }

    public function array(): array
    {
        return $this->cadries;
    }

    public function headings(): array
    {
        return [
            [
                ''
            ],
            [
                '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
                'УТВЕРЖДАЮ: _________________'
            ],
            [
                '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
                'Финансовый директор:  Очилов А.И.'
            ],
            [
                '','ИП ООО "ODASH ENERJI CA"','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
                '"_____"_______________2023 г'
            ],
            [
                'ТАБЕЛЬ за '
            ],
            [
                '№','Ф.И.О','','Число месяца','','','','','','','','','','','','','','',
                'Итого отработано за 1 пол. мес дн/ч','Число месяца','','','','','','','','',
                '','','','','','','','Итого отработано за 2 пол. мес дн/ч','Итого отработано за месяц',
                '','','','','Кол-во дней (часов) неявок','',
            ],
            [
                '','','','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','',
                '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','',
                'часов','','',''
            ],
            [
                '','','','','','','','','','','','','','','','','','','',
                '','','','','','','','','','','','','','','','','',
                'Всего','из них','',''
            ],
            [
                '','','','','','','','','','','','','','','','','','','',
                '','','','','','','','','','','','','','','','','',
                '','сверхурочных','ночных','выходных, праздничных',
                '','код','кол-во дней (часов)'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {

        return [
            // Style the first row as bold text.
            'X3'  => ['font' => ['bold' => true]],
            'X4'  => ['font' => ['bold' => true]],
            'AA3'  => ['font' => ['bold' => true]],
            'AA4'  => ['font' => ['bold' => true]],
            'AQ3'  => ['font' => ['bold' => true]],
            'AC'  => ['font' => ['bold' => true]],
            'R'  => ['font' => ['bold' => true]],
            'AH'  => ['font' => ['bold' => true]],
            'B5'  => ['font' => ['bold' => true]]
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A5:AQ' . $this->count)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A5:AQ'  . $this->count)
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A5:AQ' . $this->count)
                    ->getAlignment()
                    ->setWrapText(true);

                    $event->sheet->getStyle('A6:AQ' . $this->count)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]
                    ]);

                    $event->sheet->getDelegate()->getStyle('A5:AQ9')
                        ->getFont()
                        ->setBold(true);

                        $event->sheet->getDelegate()->getStyle('A10:C'. $this->count)
                        ->getFont()
                        ->setBold(true);
                        $event->sheet->getDelegate()->getStyle('B4:B4')
                        ->getFont()
                        ->setBold(true);
                        $event->sheet->getDelegate()->getStyle('AL2:AL2')
                        ->getFont()
                        ->setBold(true);

                $event->sheet->mergeCells('A5:AQ5');
                $event->sheet->mergeCells('A6:A9');
                $event->sheet->mergeCells('D6:R6');
                $event->sheet->mergeCells('B6:B9');
                $event->sheet->mergeCells('C6:C9');
                $event->sheet->mergeCells('D7:D9');
                $event->sheet->mergeCells('E7:E9');
                $event->sheet->mergeCells('D7:D9');
                $event->sheet->mergeCells('F7:F9');
                $event->sheet->mergeCells('G7:G9');
                $event->sheet->mergeCells('H7:H9');
                $event->sheet->mergeCells('I7:I9');
                $event->sheet->mergeCells('J7:J9');
                $event->sheet->mergeCells('K7:K9');
                $event->sheet->mergeCells('L7:L9');
                $event->sheet->mergeCells('M7:M9');
                $event->sheet->mergeCells('N7:N9');
                $event->sheet->mergeCells('O7:O9');
                $event->sheet->mergeCells('P7:P9');
                $event->sheet->mergeCells('Q7:Q9');
                $event->sheet->mergeCells('R7:R9');
                $event->sheet->mergeCells('T7:T9');
                $event->sheet->mergeCells('U7:U9');
                $event->sheet->mergeCells('V7:V9');
                $event->sheet->mergeCells('W7:W9');
                $event->sheet->mergeCells('X7:X9');
                $event->sheet->mergeCells('Y7:Y9');
                $event->sheet->mergeCells('Z7:Z9');
                $event->sheet->mergeCells('AA7:AA9');
                $event->sheet->mergeCells('AB7:AB9');
                $event->sheet->mergeCells('AC7:AC9');
                $event->sheet->mergeCells('AD7:AD9');
                $event->sheet->mergeCells('AE7:AE9');
                $event->sheet->mergeCells('AF7:AF9');
                $event->sheet->mergeCells('AG7:AG9');
                $event->sheet->mergeCells('AH7:AH9');
                $event->sheet->mergeCells('AI7:AI9');
                $event->sheet->mergeCells('T6:AI6');
                $event->sheet->mergeCells('S6:S9');
                $event->sheet->mergeCells('AJ6:AJ9');
                $event->sheet->mergeCells('AK6:AO6');
                $event->sheet->mergeCells('AK8:AK9');
                $event->sheet->mergeCells('AK7:AN7');
                $event->sheet->mergeCells('AL8:AN8');
                $event->sheet->mergeCells('AO7:AO9');
                $event->sheet->mergeCells('AP6:AQ8');

                $x = 10; 
                for ($i=1; $i <= $this->itemcount; $i++) { 
                    $event->sheet->mergeCells('B'. $x .':B'. ($x+2));
                    $event->sheet->mergeCells('A'. $x .':A'. ($x+2));
                    $x = $x+3;
                }

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AB')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AD')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AE')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AF')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AH')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('AI')->setWidth(4);

            },
        ];
    }


}
