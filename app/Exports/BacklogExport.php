<?php

namespace App\Exports;

use App\Models\Backlog;
use Maatwebsite\Excel\Concerns\FromCollection;

class BacklogExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Backlog::all();
    }
}
