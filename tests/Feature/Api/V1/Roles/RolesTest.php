<?php

use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('shows all roles', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles');

    $response
        ->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('can paginate roles based on user query', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles?per_page=2');
    $response
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJson([
            'links' => [],
        ]);
});

it('can show single role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles/2');

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => 2,
                'name' => 'admin',
            ],
        ]);
});

it('only shows specific fields', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles/2');

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

it('can delete role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $role = Role::create(['guard_name' => 'api', 'name' => 'newRole']);

    $response = $this->actingAs($user)->delete('/api/v1/roles/'.$role->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

it('can create role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/roles', [
        'name' => 'newRole',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'newRole',
            ],
        ]);
});

it('can update role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $role = Role::create(['guard_name' => 'api', 'name' => 'newRole']);

    $response = $this->actingAs($user)->patch('/api/v1/roles/'.$role->id, [
        'name' => 'anotherRole',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'anotherRole',
            ],
        ]);
});

it('can assign permissions to role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $role = Role::create(['guard_name' => 'api', 'name' => 'newRole']);

    $response = $this->actingAs($user)->post('/api/v1/roles/'.$role->id.'/assign', [
        'permissions' => [
            'users:view',
            'users:create',
        ],
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'permissions' => [
                    [
                        'name' => 'users:view',
                    ],
                    [
                        'name' => 'users:create',
                    ],
                ],
            ],
        ]);
});

it('can revoke permissions from role', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'superadmin@example.com')->first(),
        ['*'],
    );

    $role = Role::create(['guard_name' => 'api', 'name' => 'newRole']);
    $role->givePermissionTo('users:view');
    $role->givePermissionTo('users:create');

    $response = $this->actingAs($user)->post('/api/v1/roles/'.$role->id.'/revoke', [
        'permissions' => [
            'users:view',
            'users:create',
        ],
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonMissing([
            'data' => [
                'permissions' => [
                    [
                        'name' => 'users:view',
                    ],
                    [
                        'name' => 'users:create',
                    ],
                ],
            ],
        ]);
});
