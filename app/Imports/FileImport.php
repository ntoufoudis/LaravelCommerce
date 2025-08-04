<?php

namespace App\Imports;

use Vitorccs\LaravelCsv\Concerns\Importables\FromFile;
use Vitorccs\LaravelCsv\Concerns\Importables\Importable;

class FileImport implements FromFile
{
    use Importable;

    public function fileName(): string
    {
        return storage_path().'/products.csv';
    }
}
