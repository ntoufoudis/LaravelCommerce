<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all users', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    User::factory(10)->create();

    $response = $this->get('/api/v1/users');

    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('paginates users', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    User::factory(20)->create();

    $response = $this->get('/api/v1/users');
    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can paginate based on user query users', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    User::factory(30)->create();

    $response = $this->get('/api/v1/users?per_page=15');
    $response
        ->assertStatus(200)
        ->assertJsonCount(15, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single user', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $user = User::factory()->create();

    $response = $this->get('/api/v1/users/2');

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('only shows specific fields', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $user = User::factory()->create();

    $response = $this->get('/api/v1/users/2');

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'password',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('can delete user', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $user = User::factory()->create();

    $response = $this->delete('/api/v1/users/'.$user->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

it('can create user', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $response = $this->post('/api/v1/users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Test User',
            ],
        ]);
});

it('can update user', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $user = User::factory()->create();

    $response = $this->patch('/api/v1/users/'.$user->id, [
        'name' => 'Updated User',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Updated User',
            ],
        ]);
});

it('can replace user', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $user = User::factory()->create();

    $response = $this->put('/api/v1/users/'.$user->id, [
        'name' => 'Updated User',
        'email' => 'new@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Updated User',
                'email' => 'new@email.com',
            ],
        ]);
});
