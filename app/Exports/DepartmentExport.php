<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DepartmentExport implements FromArray,WithHeadings,WithStyles,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
    protected $arr, $col, $count;

    public function __construct($arr, $col, $count)
    {
        $this->arr = $arr;
        $this->col = $col;
        $this->count = $count;
    }

    
    public function array(): array
    {
        return $this->arr;
    }

    public function headings(): array
    {
        return [
            [
               ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
            ],
            [
               ' ',' ',' ',' ',' ',' ',' ',' ','"УТВЕРЖДАЮ"',' ',' ',' ',' ',
            ],
            [
                ' ',' ',' ',' ',' ',' ',' ',' ','"Иностранное предприятие     " ODAS ENERJI  CA" "',' ',' ',' ',' ',
             ],
             [
                ' ',' ',' ',' ',' ',' ',' ',' ','Генеральный директор',' ',' ',' ',' ',
             ],
             [
                ' ',' ',' ',' ',' ',' ',' ',' ','__________________Ахмет Джан Гоксал',' ',' ',' ',' ',
             ],
             [
                ' ',' ',' ',' ',' ',' ',' ',' ','"01" март 2023 год',' ',' ',' ',' ',
             ],
             [
                ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
            ], 
            [
                ' ',' ','ШТАТНОЕ РАСПИСАНИЕ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
            ], 
            [
                ' ',' ','Иностранное предприятие  ООО  "ODAS ENERJI CA" ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
            ], 
            [
                ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
            ], 
            [
                ' ','№','Должность','Количество ','Ф.И.О.','Должностной разряд ','Тарифный коэффициент','Минимальная сумма','Должностной  оклад','Ставка','Вакансия ',' ХТТ и  БПТ','УМУМИЙ',
            ]
           
        ];
    }

    public function styles(Worksheet $sheet)
    {

       
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                
                $event->sheet->mergeCells('I2:L2');
                $event->sheet->mergeCells('I3:L3');
                $event->sheet->mergeCells('I4:L4');
                $event->sheet->mergeCells('I5:L5');
                $event->sheet->mergeCells('I6:L6');
                $event->sheet->mergeCells('C8:M8');
                $event->sheet->mergeCells('C9:M9');

                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(70);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(47);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(15);

                $event->sheet->getDelegate()->getStyle('A1:AV'. (11+$this->count))
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B1:AV' . (11+$this->count))
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B11:M' . (11 + $this->count))
                    ->getAlignment()
                    ->setWrapText(true);

                $event->sheet->getStyle('B11:M'. (11+$this->count) )->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]
                    ]);

                $event->sheet->getDelegate()->getStyle('I2:I6')
                    ->getFont()
                    ->setBold(true);
                $event->sheet->getDelegate()->getStyle('C8:C9')
                    ->getFont()
                    ->setBold(true);

                $event->sheet->mergeCells('B12:M12');
                
                $event->sheet->getDelegate()->getStyle('B11:M12')
                ->getFont()
                ->setBold(true);

                $event->sheet->getDelegate()->getStyle('B11:M11')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('3F86BA');

                $event->sheet->getDelegate()->getStyle('B12')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('B4C6E7');
                

                $x = 13;

                foreach($this->col as $item)
                {
                    $event->sheet->mergeCells('B' . ($x + $item) . ':C' . ($x + $item));
                    $event->sheet->mergeCells('B' . ($x + $item + 1) . ':M' . ($x + $item + 1));

                    $event->sheet->getDelegate()->getStyle('B' . ($x + $item) . ':M' . ($x + $item))
                    ->getFont()
                    ->setBold(true);

                    $event->sheet->getDelegate()->getStyle('B' . ($x + $item + 1))
                    ->getFont()
                    ->setBold(true);

                    $event->sheet->getDelegate()->getStyle('B' . ($x + $item + 1) . ':M' . ($x + $item + 1))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('B4C6E7');

                    $x = $x + $item + 2;

                }

            },
        ];
    }

}
