<?php

use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('does not allow to view all tags without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/tags');

    $response->assertStatus(403);
});

it('allows to view all tags with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/tags');

    $response->assertStatus(200);
});

it('does not allow to view single tag without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/tags/1');

    $response->assertStatus(403);
});

it('allows to view single tag with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/tags/1');

    $response->assertStatus(200);
});

it('does not allow to store new tag without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/tags', [
        'name' => 'newTag',
    ]);

    $response->assertStatus(403);
});

it('allows to store new tag with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->postJson('/api/v1/tags', [
        'name' => 'newTag',
    ]);

    $response->assertStatus(201);
});

it('does not allow to update tag without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $tag = Tag::create(['name' => 'newTag']);

    $response = $this->actingAs($user)->patch('/api/v1/tags/'.$tag->id, [
        'name' => 'anotherTag',
    ]);

    $response->assertStatus(403);
});

it('allows to update tag with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::create(['name' => 'newTag']);

    $response = $this->actingAs($user)->patch('/api/v1/tags/'.$tag->id, [
        'name' => 'anotherTag',
    ]);

    $response->assertStatus(200);
});

it('does not allow to delete tag without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $tag = Tag::create(['name' => 'newTag']);

    $response = $this->actingAs($user)->delete('/api/v1/tags/'.$tag->id);

    $response->assertStatus(403);
});

it('allows to delete tag with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $tag = Tag::create(['name' => 'newTag']);

    $response = $this->actingAs($user)->delete('/api/v1/tags/'.$tag->id);

    $response->assertStatus(200);
});
