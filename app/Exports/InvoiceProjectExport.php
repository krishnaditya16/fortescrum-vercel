<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceProjectExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{

    public $invoices;

    public function __construct($invoices) {
        $this->invoices = $invoices;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::join('clients', 'invoices.client_id', 'clients.id')
            ->whereIn('invoices.id', $this->invoices)
            ->select('invoices.id', 'clients.name', 'clients.address', 'issued', 'deadline', 'inv_status', 'invoices.created_at', 'invoices.updated_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Client',
            'Address',
            'Issued Date',
            'Deadline',
            'Status',
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
