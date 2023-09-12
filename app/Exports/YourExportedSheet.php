<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class YourExportedSheet implements FromCollection
{
    public function collection()
    {
        // Specify the sheet name you want to export
        return collect([
            // Your data goes here
        ]);
    }
}
