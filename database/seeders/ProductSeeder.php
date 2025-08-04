<?php

namespace Database\Seeders;

use App\Imports\FileImport;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = (new FileImport)->getArray();
        array_splice($data, 0, 1);

        foreach ($data as $product) {
            Product::create([
                'sku' => $product[2],
                'name' => $product[3],
                'short_description' => $product[7],
                'description' => $product[8],
                'price' => $product[24],

            ]);
        }
    }
}
