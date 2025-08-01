<?php

use App\Models\Permission;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all permissions', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions');

    $response
        ->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('can paginate permissions based on user query', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions?per_page=2');
    $response
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single permissions', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions/2');

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => 2,
            ],
        ]);
});

it('only shows specific fields', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions/2');

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'created_at',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => 2,
            ],
        ]);
});

it('can delete permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $permission = Permission::create(['guard_name' => 'api', 'name' => 'newPermission']);

    $response = $this->actingAs($user)->delete('/api/v1/permissions/'.$permission->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
});

it('can create permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/permissions', [
        'name' => 'newPermission',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'newPermission',
            ],
        ]);
});

it('can update permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $permission = Permission::create(['guard_name' => 'api', 'name' => 'newPermission']);

    $response = $this->actingAs($user)->patch('/api/v1/permissions/'.$permission->id, [
        'name' => 'anotherPermission',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'anotherPermission',
            ],
        ]);
});
