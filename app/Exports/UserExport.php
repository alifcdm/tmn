<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all();
    }
    public function headings(): array
    {
        return [
            'ID', 'Fullname', 'NIP', 'Role', 'Email', 'Phone', 'Address', 'Updated-at', 'Created-at'
        ];
    }
}
