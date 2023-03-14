<?php

namespace App\Exports;

// use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromView;
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
    
    protected $days, $arrm , $cCount;

    public function __construct($days, $arr, $cCount)
    {
        $this->days = $days;
        $this->arr = $arr;
        $this->cCount = $cCount;
    }
    
    // public function view(): View
    // {
    //     set_time_limit(1000);
        
    //     return view('export.tabel', [

    //     ]);
    // }

    public function array(): array
    {
        return $this->arr;
    }

    public function headings(): array
    {
        return [
            [
                'ОТДЕЛ ОБЕСПЕЧЕНИЯ ИНФОРМАЦИОННОЙ БЕЗОПАСНОСТИ'
            ],
            [
                'ОТДЕЛ ОБЕСПЕЧЕНИЯ ИНФОРМАЦИОННОЙ БЕЗОПАСНОСТИ'
            ],
            [
               'Пердприятие','','','','','','','','','','','','','','','','','','','','','','',
               'Месяц','','',
               'Год','','','',
               'Цех','','','',
               'Участок','','','',
               'Бригада','','','',
               'Форма ФТУ №3'
            ],
            [
               'Отдел ИБ (ВЦ)','','','','','','','','','','','','','','','','','','','','','','',
               '12','','',
               '2023','','','',
               '20'
            ],
            [
                '1 -я  стр',
                'Фамилия, имя, отчества','','','','','','','','','','','','','','','',
                'дней','','','','','','','',
                'выходные  и празничные дни',
                'недор. час','',
                'отработаный час','','','','',
                'Табельный номер',
                'Установленный КТУ',
                'пр.распр. Экономеи',
                'Выд оплаты',
                'Схема расчета',
                'Синтеческий чсет и супсчет',
                'Статья расхода',
                'Дополнительный признак',
                'Код премии',
                'процент из примии из ФЗП',
                'процент примии из ФМП',
                'Дни фактический работ',
                'часи фактических работ',
                'дни'
            ],
            [
                '',
                '','','','','','','','','','','','','','','','',
                'явок','',
                'неявок','','','','','','',
                '','',
                'Всего','сделно','из них','','','','','','','','','','','','','','','','фактический работы','Выходные и празнич'
            ],
            [
                '','','','','','','','','','','','','','','','','',
                'фактический работы',
                'целосменых простов',
                'очередной отпуск',
                'отсукс в св с родами',
                'болезень',
                'пр.неявки разрешения',
                'с разреш админестрац',
                'прогул','',
                'текущей простой',
                'опозжание преж.',
                '','','свыхурочный','ночной','празнычный',

            ],
            [
                '', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,''
            ],
            [
                '',16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31
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
            'B5'  => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 9]],
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

                $event->sheet->getPageMargins()
                    ->setLeft(0.25)
                    ->setRight(0.25)
                    ->setTop(0.5)
                    ->setBottom(0.5)
                    ->setHeader(0);

                $event->sheet->getDelegate()->getStyle('B:Q')
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $event->sheet->getStyle('A1:AV'. (9 + ($this->cCount)*4) )->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);
                
                foreach($this->days as $day)
                {
                    $event->sheet->getDelegate()->getStyle($this->getDay($day))
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('000000');

                    $event->sheet->getStyle($this->getDay($day))->applyFromArray([
                        'font' => array(
                            'color' => ['argb' => 'ffffff'],
                        )
                    ]);
                }
                
                for($i = 1; $i<=$this->cCount; $i++)
                {
                    $event->sheet->mergeCells('B' . (6 + $i*4) . ':Q' . (7 + $i*4));
                    $event->sheet->mergeCells('A' . (6 + $i*4) . ':A' . (9 + $i*4));

                    $event->sheet->mergeCells('R'. (6 + $i*4) .':R' . (9 + $i*4));
                    $event->sheet->mergeCells('S'. (6 + $i*4) .':S' . (9 + $i*4));
                    $event->sheet->mergeCells('T'. (6 + $i*4) .':T' . (9 + $i*4));
                    $event->sheet->mergeCells('U'. (6 + $i*4) .':U' . (9 + $i*4));
                    $event->sheet->mergeCells('V'. (6 + $i*4) .':V' . (9 + $i*4));
                    $event->sheet->mergeCells('W'. (6 + $i*4) .':W' . (9 + $i*4));
                    $event->sheet->mergeCells('X'. (6 + $i*4) .':X' . (9 + $i*4));
                    $event->sheet->mergeCells('Y'. (6 + $i*4) .':Y' . (9 + $i*4));
                    $event->sheet->mergeCells('Z'. (6 + $i*4) .':Z' . (9 + $i*4));
                    $event->sheet->mergeCells('AA'. (6 + $i*4) .':AA' . (9 + $i*4));
                    $event->sheet->mergeCells('AB'. (6 + $i*4) .':AB' . (9 + $i*4));
                    $event->sheet->mergeCells('AC'. (6 + $i*4) .':AC' . (9 + $i*4));
                    $event->sheet->mergeCells('AD'. (6 + $i*4) .':AD' . (9 + $i*4));
                    $event->sheet->mergeCells('AE'. (6 + $i*4) .':AE' . (9 + $i*4));
                    $event->sheet->mergeCells('AF'. (6 + $i*4) .':AF' . (9 + $i*4));
                    $event->sheet->mergeCells('AG'. (6 + $i*4) .':AG' . (9 + $i*4));
                    $event->sheet->mergeCells('AH'. (6 + $i*4) .':AH' . (9 + $i*4));
                    $event->sheet->mergeCells('AI'. (6 + $i*4) .':AI' . (9 + $i*4));
                    $event->sheet->mergeCells('AJ'. (6 + $i*4) .':AJ' . (9 + $i*4));
                    $event->sheet->mergeCells('AK'. (6 + $i*4) .':AK' . (9 + $i*4));
                    $event->sheet->mergeCells('AL'. (6 + $i*4) .':AL' . (9 + $i*4));
                    $event->sheet->mergeCells('AM'. (6 + $i*4) .':AM' . (9 + $i*4));
                    $event->sheet->mergeCells('AN'. (6 + $i*4) .':AN' . (9 + $i*4));
                    $event->sheet->mergeCells('AO'. (6 + $i*4) .':AO' . (9 + $i*4));
                    $event->sheet->mergeCells('AP'. (6 + $i*4) .':AP' . (9 + $i*4));
                    $event->sheet->mergeCells('AQ'. (6 + $i*4) .':AQ' . (9 + $i*4));
                    $event->sheet->mergeCells('AR'. (6 + $i*4) .':AR' . (9 + $i*4));
                    $event->sheet->mergeCells('AS'. (6 + $i*4) .':AS' . (9 + $i*4));
                    $event->sheet->mergeCells('AT'. (6 + $i*4) .':AT' . (9 + $i*4));
                    $event->sheet->mergeCells('AU'. (6 + $i*4) .':AU' . (9 + $i*4));
                    $event->sheet->mergeCells('AV'. (6 + $i*4) .':AV' . (9 + $i*4));
                }
                

                $event->sheet->getDelegate()->getStyle('R7:Y7')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AH5:AT5')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('Z5')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AA7:AB7')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AC6:AE6')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AE7:AG7')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AU5')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AC5')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('AA5')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('R6')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('T6')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('R5')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('Au6:AV6')->getFont()->setSize(9);

                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(25);
                $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(25);
                $event->sheet->getDelegate()->getRowDimension('9')->setRowHeight(25);

                $event->sheet->getDelegate()->getStyle('A1:AV' . (9 + ($this->cCount) * 4))
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('R10:AV'. (9 + ($this->cCount) * 4))
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


                $cells = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                        
                    'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP',
                ];
                            
                foreach ($cells as $cell) {
                    $event->sheet->getDelegate()->getColumnDimension($cell)->setWidth(3);
                }

                $cells = ['AQ','AR','AS','AT','AU','AV'];

                foreach ($cells as $cell) {
                    $event->sheet->getDelegate()->getColumnDimension($cell)->setWidth(2.5);
                }

                $event->sheet->mergeCells('A1:AV1');
                $event->sheet->mergeCells('A2:AV2');
                $event->sheet->mergeCells('A3:W3');
                $event->sheet->mergeCells('A4:W4');
                $event->sheet->mergeCells('X3:Z3');
                $event->sheet->mergeCells('X4:Z4');
                $event->sheet->mergeCells('AA3:AD3');
                $event->sheet->mergeCells('AA4:AD4');
                $event->sheet->mergeCells('AE3:AH3');
                $event->sheet->mergeCells('AE4:AH4');
                $event->sheet->mergeCells('AI3:AL3');
                $event->sheet->mergeCells('AI4:AL4');
                $event->sheet->mergeCells('AM3:AP3');
                $event->sheet->mergeCells('AM4:AP4');
                $event->sheet->mergeCells('AQ3:AV4');

                $event->sheet->mergeCells('B5:Q6');
                $event->sheet->mergeCells('B7:Q7');
                $event->sheet->mergeCells('R5:Y5');
                $event->sheet->mergeCells('AA5:AB6');
                $event->sheet->mergeCells('AC5:AG5');
                $event->sheet->mergeCells('AU5:AV5');
                $event->sheet->mergeCells('A5:A9');
                $event->sheet->mergeCells('R6:S6');
                $event->sheet->mergeCells('T6:Y6');
                $event->sheet->mergeCells('R7:R9');
                $event->sheet->mergeCells('S7:S9');
                $event->sheet->mergeCells('T7:T9');
                $event->sheet->mergeCells('U7:U9');
                $event->sheet->mergeCells('V7:V9');
                $event->sheet->mergeCells('W7:W9');
                $event->sheet->mergeCells('X7:X9');
                $event->sheet->mergeCells('Y7:Y9');
                $event->sheet->mergeCells('Z5:Z9');
                $event->sheet->mergeCells('AA7:AA9');
                $event->sheet->mergeCells('AB7:AB9');
                $event->sheet->mergeCells('AC6:AC9');
                $event->sheet->mergeCells('AD6:AD9');
                $event->sheet->mergeCells('AE6:AG6');
                $event->sheet->mergeCells('AE7:AE9');
                $event->sheet->mergeCells('AF7:AF9');
                $event->sheet->mergeCells('AG7:AG9');

                
                $event->sheet->mergeCells('AH5:AH9');
                $event->sheet->mergeCells('AI5:AI9');
                $event->sheet->mergeCells('AJ5:AJ9');
                $event->sheet->mergeCells('AK5:AK9');
                $event->sheet->mergeCells('AL5:AL9');
                $event->sheet->mergeCells('AM5:AM9');
                $event->sheet->mergeCells('AN5:AN9');
                $event->sheet->mergeCells('AO5:AO9');
                $event->sheet->mergeCells('AP5:AP9');
                $event->sheet->mergeCells('AQ5:AQ9');
                $event->sheet->mergeCells('AR5:AR9');
                $event->sheet->mergeCells('AS5:AS9');
                $event->sheet->mergeCells('AT5:AT9');
                $event->sheet->mergeCells('AU6:AU9');
                $event->sheet->mergeCells('AV6:AV9');

                $event->sheet->getStyle("A5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("R7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("S7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("T7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AH5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AJ5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AK5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AL5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AM5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AN5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AO5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AP5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AQ5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AR5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AS5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AT5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AU6")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AV6")->getAlignment()->setTextRotation(90);

                
                $event->sheet->getStyle("U7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("V7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("W7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("X7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("Y7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("Z5")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AA7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AB7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AC6")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AD6")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AE7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AF7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AG7")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("AI5")->getAlignment()->setTextRotation(90);

            },
        ];
    }

    public function getDay($i)
    {
        if($i == 1) return 'B8'; else 
        if($i == 2) return 'C8'; else 
        if($i == 3) return 'D8'; else 
        if($i == 4) return 'E8'; else 
        if($i == 5) return 'F8'; else 
        if($i == 6) return 'G8'; else 
        if($i == 7) return 'H8'; else 
        if($i == 8) return 'I8'; else 
        if($i == 9) return 'J8'; else 
        if($i == 10) return 'K8'; else 
        if($i == 11) return 'L8'; else 
        if($i == 12) return 'M8'; else 
        if($i == 13) return 'N8'; else 
        if($i == 14) return 'O8'; else 
        if($i == 15) return 'P8'; else 
        if($i == 16) return 'B9'; else 
        if($i == 17) return 'C9'; else 
        if($i == 18) return 'D9'; else 
        if($i == 19) return 'E9'; else 
        if($i == 20) return 'F9'; else 
        if($i == 21) return 'G9'; else 
        if($i == 22) return 'H9'; else 
        if($i == 23) return 'I9'; else 
        if($i == 24) return 'J9'; else 
        if($i == 25) return 'K9'; else 
        if($i == 26) return 'L9'; else 
        if($i == 27) return 'M9'; else 
        if($i == 28) return 'N9'; else 
        if($i == 29) return 'O9'; else 
        if($i == 30) return 'P9'; else 
        if($i == 31) return 'Q9'; 
    }
    

}
