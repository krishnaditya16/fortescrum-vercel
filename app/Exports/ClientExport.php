<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    
    /**
    * @return \Illuminate\Support\Collection
    */

    public $clients;

    public function __construct($clients) {
        $this->clients = $clients;
    }

    public function collection()
    {
        return Client::whereIn('id', $this->clients)->select('id', 'name', 'email', 'phone_number', 'address', 'created_at', 'updated_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone Number',
            'Address',
            'Created at',
            'Updated at',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
        1    => ['font' => ['bold' => true]],
        ];
    }
}
