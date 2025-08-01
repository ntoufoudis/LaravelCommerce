<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('does not allow to view all users without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/users');

    $response->assertStatus(403);
});

it('allows to view all users with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/users');

    $response->assertStatus(200);
});

it('does not allow to view single user without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/users/1');

    $response->assertStatus(403);
});

it('allows to view single user with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/users/1');

    $response->assertStatus(200);
});

it('does not allow to store new user without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/users', [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(403);
});

it('allows to store new user with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->postJson('/api/v1/users', [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);
});

it('does not allow to update user without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->patch('/api/v1/users/'.$user1->id, [
        'name' => 'John Doe',
    ]);

    $response->assertStatus(403);
});

it('allows to update user with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->patch('/api/v1/users/'.$user1->id, [
        'name' => 'John Doe',
    ]);

    $response->assertStatus(200);
});

it('does not allow to delete user without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->delete('/api/v1/users/'.$user1->id);

    $response->assertStatus(403);
});

it('allows to delete user with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->delete('/api/v1/users/'.$user1->id);

    $response->assertStatus(200);
});
