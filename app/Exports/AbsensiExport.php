<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class AbsensiExport implements FromCollection, WithHeadings
{
    /** @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $absensi = DB::table('absensi')
            ->join('users', 'absensi.user_id', '=', 'users.id')
            ->select('absensi.id', 'users.fullname', 'absensi.status', 'absensi.clock_in', 'absensi.clock_out')
            ->get();

        return $absensi;
    }
    public function headings(): array
    {
        return [
            'ID', 'Nama',  'Status', 'Clock_In', 'Clock_Out'
        ];
    }
}
