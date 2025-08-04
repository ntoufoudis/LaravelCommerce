<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all products', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/products');

    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('can paginate products based on user query', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/products?per_page=2');
    $response
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single product', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $product = Product::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/products/'.$product->id);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
            ],
        ]);
});

it('only shows specific fields', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $product = Product::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/products/'.$product->id);

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'created_at',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $product->id,
            ],
        ]);
});

it('can delete product', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $product = Product::create([
        'name' => 'newProduct',
        'price' => 1,
        'sku' => '123-23',
    ]);

    $response = $this->actingAs($user)->delete('/api/v1/products/'.$product->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

it('can create product', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/products', [
        'name' => 'newProduct',
        'price' => 1,
        'sku' => '123-23',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'newProduct',
            ],
        ]);
});

it('can update product', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $product = Product::create([
        'name' => 'newProduct',
        'price' => 1,
        'sku' => '123-23',
    ]);

    $response = $this->actingAs($user)->patch('/api/v1/products/'.$product->id, [
        'name' => 'anotherProduct',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'anotherProduct',
            ],
        ]);
});

it('can replace product', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $product = Product::factory()->create();

    $response = $this->actingAs($user)->put('/api/v1/products/'.$product->id, [
        'name' => 'New Product',
        'slug' => 'some-product',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'New Product',
                'slug' => 'some-product',
            ],
        ]);
});

it('can attach categories to product', function () {
    Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $product = Product::factory()->create();

    $product->categories()->attach([1, 2, 3]);

    $this->assertEquals(3, $product->categories()->count());
    $this->assertEquals(1, Category::first()->products()->count());
});

it('can attach tags to product', function () {
    Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    Tag::factory(2)->create();

    $product = Product::factory()->create();

    $product->tags()->attach([1, 2]);

    $this->assertEquals(2, $product->tags()->count());
    $this->assertEquals(1, Tag::first()->products()->count());
});
