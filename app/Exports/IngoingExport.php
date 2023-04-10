<?php

namespace App\Exports;

use App\Models\IngoingMail;
use Maatwebsite\Excel\Concerns\FromCollection;

class IngoingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return IngoingMail::all();
    }
}
