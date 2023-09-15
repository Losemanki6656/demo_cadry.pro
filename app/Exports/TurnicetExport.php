<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TurnicetExport implements FromArray,WithHeadings,WithStyles,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
    protected $arr, $count;

    public function __construct($arr, $count)
    {
        $this->arr = $arr;
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

                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(70);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);

                


            },
        ];
    }

}
