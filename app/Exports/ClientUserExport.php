<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientUserExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    // public function collection()
    // {
    //     return Client::whereIn('id', $this->clients)->select('id', 'name', 'email', 'phone_number', 'address', 'created_at', 'updated_at')->get();
    // }

    public function query()
    {
        return Client::query()
        ->join('users', 'clients.user_id', '=', 'users.id')
        ->join('teams', 'users.current_team_id', '=', 'teams.id')
        ->join('team_user', 'teams.id', '=', 'team_user.team_id') 
        ->where('team_user.role', '=', 'client-user')
        ->whereIn('users.id', $this->clients)
        ->select('users.id', 'clients.name', 'users.email', 'clients.phone_number', 'users.created_at', 'users.updated_at');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Client',
            'User Email',
            'Phone Number',
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
