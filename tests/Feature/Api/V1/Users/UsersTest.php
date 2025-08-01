<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all users', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    User::factory(10)->create();

    $response = $this->actingAs($user)->get('/api/v1/users');

    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('paginates users', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    User::factory(20)->create();

    $response = $this->actingAs($user)->get('/api/v1/users');
    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can paginate based on user query users', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    User::factory(30)->create();

    $response = $this->actingAs($user)->get('/api/v1/users?per_page=15');
    $response
        ->assertStatus(200)
        ->assertJsonCount(15, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single user', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/users/'.$user1->id);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user1->id,
                'name' => $user1->name,
                'email' => $user1->email,
            ],
        ]);
});

it('only shows specific fields', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/users/'.$user1->id);

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'password',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $user1->id,
                'name' => $user1->name,
                'email' => $user1->email,
            ],
        ]);
});

it('can delete user', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->delete('/api/v1/users/'.$user1->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('users', ['id' => $user1->id]);
});

it('can create user', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/users', [
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

it('can create user with specific role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Test User',
                'roles' => [
                    'admin',
                ],
            ],
        ]);
});

it('can update user', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->patch('/api/v1/users/'.$user1->id, [
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
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $user1 = User::factory()->create();

    $response = $this->actingAs($user)->put('/api/v1/users/'.$user1->id, [
        'name' => 'Updated User',
        'email' => 'new@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'customer',
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
