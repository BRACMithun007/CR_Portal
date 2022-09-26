<?php

namespace App\Exports;

use App\changeRequestMaster;
use Maatwebsite\Excel\Concerns\FromCollection;

class reportExport implements FromCollection
{
    public function collection()
    {
        return changeRequestMaster::all();
    }
}
