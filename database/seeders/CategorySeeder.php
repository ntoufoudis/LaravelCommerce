<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $clothing = Category::create([
            'name' => 'Clothing',
        ]);

        $men = Category::create([
            'name' => 'Men',
            'parent_id' => $clothing->id,
        ]);

        $tops = Category::create([
            'name' => 'Tops',
            'parent_id' => $men->id,
        ]);

        Category::create([
            'name' => 'Hoodies & Sweatshirts',
            'parent_id' => $tops->id,
        ]);

        Category::create([
            'name' => 'Jackets',
            'parent_id' => $tops->id,
        ]);

        $collections = Category::create([
            'name' => 'Collections',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Eco Friendly',
            'parent_id' => $collections->id,
        ]);

        $bottoms = Category::create([
            'name' => 'Bottoms',
            'parent_id' => $men->id,
        ]);

        Category::create([
            'name' => 'Pants',
            'parent_id' => $bottoms->id,
        ]);

        $promotions = Category::create([
            'name' => 'Promotions',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Pants',
            'parent_id' => $promotions->id,
        ]);

        Category::create([
            'name' => 'Performance Fabrics',
            'parent_id' => $collections->id,
        ]);

        Category::create([
            'name' => 'New Luma Yoga Collection',
            'parent_id' => $collections->id,
        ]);

        Category::create([
            'name' => 'Erin Recommends',
        ]);

        Category::create([
            'name' => 'Tees',
            'parent_id' => $tops->id,
        ]);

        Category::create([
            'name' => 'Shorts',
            'parent_id' => $bottoms->id,
        ]);

        Category::create([
            'name' => 'Men Sale',
            'parent_id' => $promotions->id,
        ]);

        Category::create([
            'name' => 'Tanks',
            'parent_id' => $tops->id,
        ]);

        $women = Category::create([
            'name' => 'Women',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Bras & Tanks',
            'parent_id' => $women->id,
        ]);

        Category::create([
            'name' => 'Women Sale',
            'parent_id' => $promotions->id,
        ]);

        $wTop = Category::create([
            'name' => 'Tops',
            'parent_id' => $women->id,
        ]);

        Category::create([
            'name' => 'Hoodies & Sweatshirts',
            'parent_id' => $wTop->id,
        ]);

        Category::create([
            'name' => 'Jackets',
            'parent_id' => $wTop->id,
        ]);

        $wBottoms = Category::create([
            'name' => 'Bottoms',
            'parent_id' => $women->id,
        ]);

        Category::create([
            'name' => 'Pants',
            'parent_id' => $wBottoms->id,
        ]);

        Category::create([
            'name' => 'Tees',
            'parent_id' => $wTop->id,
        ]);

        Category::create([
            'name' => 'Shorts',
            'parent_id' => $wBottoms->id,
        ]);

        $gear = Category::create([
            'name' => 'Gear',
        ]);

        Category::create([
            'name' => 'Watches',
            'parent_id' => $gear->id,
        ]);

        Category::create([
            'name' => 'Fitness Equipment',
            'parent_id' => $gear->id,
        ]);

        Category::create([
            'name' => 'Bags',
            'parent_id' => $gear->id,
        ]);
    }
}
