<?php

namespace App\Exports;

// use App\Models\Salary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalariesExport implements WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array {
        return [
        	'code',
            'paid_day_off',
            'unpaid_day_off',    
        	'total_working_days',
        	'salary',
        	'month',
        	'year',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,            
            'C' => 20,            
            'D' => 20,            
            'E' => 30,            
            'F' => 10,            
            'G' => 10,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
