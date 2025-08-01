<?php

use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all tags', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/tags');

    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('can paginate tags based on user query', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/tags?per_page=2');
    $response
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single tag', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/tags/'.$tag->id);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $tag->id,
                'name' => $tag->name,
            ],
        ]);
});

it('only shows specific fields', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/tags/'.$tag->id);

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'created_at',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $tag->id,
            ],
        ]);
});

it('can delete tag', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::create(['name' => 'newTag']);

    $response = $this->actingAs($user)->delete('/api/v1/tags/'.$tag->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
});

it('can create tag', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/tags', [
        'name' => 'newTag',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'newTag',
            ],
        ]);
});

it('can update tag', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::create(['name' => 'newTag']);

    $response = $this->actingAs($user)->patch('/api/v1/tags/'.$tag->id, [
        'name' => 'anotherTag',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'anotherTag',
            ],
        ]);
});

it('can replace tag', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::factory()->create();

    $response = $this->actingAs($user)->put('/api/v1/tags/'.$tag->id, [
        'name' => 'New Tag',
        'slug' => 'some-tag',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'New Tag',
                'slug' => 'some-tag',
            ],
        ]);
});
