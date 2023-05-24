<?php

namespace App\Exports;

use App\Models\Meeting;
use Maatwebsite\Excel\Concerns\FromCollection;

class MeetingProjectExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Meeting::all();
    }
}
