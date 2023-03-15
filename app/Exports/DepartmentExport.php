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
  
    protected $arr;

    public function __construct($arr)
    {
        $this->arr = $arr;
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

            },
        ];
    }

}
