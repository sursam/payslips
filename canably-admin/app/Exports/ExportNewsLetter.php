<?php

namespace App\Exports;

use App\Models\NewsLetter;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Http\Resources\NewsLetterResource;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportNewsLetter implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles,WithEvents
{
    public function headings(): array
    {
        return [

            'First Name',
            'Last Name',
            'Email Address',
            'Contact Number',
            'Subscribed',

        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products= NewsLetter::all();
        $collection= NewsLetterResource::collection($products);
        return collect($collection);
    }

    public function styles(Worksheet $sheet){
        return [
            1    => ['font' => ['bold' => true],'freeze'=>true],
        ];
    }


    /**
     * Write code on Method
     *
     * @return \response()
     */
    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event){
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $event->sheet->getDelegate()->freezePane('B2')->getStyle('A1:E1')->applyFromArray($styleArray);
            },
        ];
    }
}
