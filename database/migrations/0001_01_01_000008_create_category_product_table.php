<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Product::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
