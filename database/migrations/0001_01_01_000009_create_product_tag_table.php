<?php

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_tag', function (Blueprint $table) {
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Tag::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_tag');
    }
};
