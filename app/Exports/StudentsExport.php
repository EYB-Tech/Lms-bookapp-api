<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StudentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::where('type', 'Student')->where('id', 0)->get();
    }

    /**
     * Define the headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'name',
            'email',
            'username',
            'password',
        ];
    }


    /**
     * Define column widths for the export.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 30, // name
            'B' => 30, // username
            'C' => 40, // email
            'D' => 40, // password
        ];
    }
}
