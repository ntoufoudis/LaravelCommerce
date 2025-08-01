<?php

use App\Models\Category;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all categories', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/categories');

    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('can paginate categories based on user query', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/categories?per_page=2');
    $response
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single category', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $category = Category::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/categories/'.$category->id);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
        ]);
});

it('only shows specific fields', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $category = Category::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/categories/'.$category->id);

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'created_at',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $category->id,
            ],
        ]);
});

it('can delete category', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $category = Category::create(['name' => 'newCategory']);

    $response = $this->actingAs($user)->delete('/api/v1/categories/'.$category->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

it('can create category', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/categories', [
        'name' => 'newCategory',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'newCategory',
            ],
        ]);
});

it('can update category', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $category = Category::create(['name' => 'newCategory']);

    $response = $this->actingAs($user)->patch('/api/v1/categories/'.$category->id, [
        'name' => 'anotherCategory',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'anotherCategory',
            ],
        ]);
});

it('can replace category', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $category = Category::factory()->create();

    $response = $this->actingAs($user)->put('/api/v1/categories/'.$category->id, [
        'name' => 'New Category',
        'slug' => 'some-category',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'New Category',
                'slug' => 'some-category',
            ],
        ]);
});
