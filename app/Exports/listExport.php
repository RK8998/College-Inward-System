<?php

namespace App\Exports;

use App\Models\listmodel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class listExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return [
            'ID',
            'Department',
            'Inward No',
            'Date',
            'Received From',
            'Subject'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return listmodel::all();
        return collect(listmodel::getList());
    }
}
