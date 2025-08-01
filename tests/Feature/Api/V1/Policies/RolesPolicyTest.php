<?php

use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('does not allow to view all roles without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles');

    $response->assertStatus(403);
});

it('allows to view all roles with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles');

    $response->assertStatus(200);
});

it('does not allow to view single role without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles/1');

    $response->assertStatus(403);
});

it('allows to view single role with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/roles/1');

    $response->assertStatus(200);
});

it('does not allow to store new role without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/roles', [
        'name' => 'newRole',
    ]);

    $response->assertStatus(403);
});

it('allows to store new role with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->postJson('/api/v1/roles', [
        'name' => 'newRole',
    ]);

    $response->assertStatus(201);
});

it('does not allow to update role without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $role1 = Role::create(['name' => 'newRole']);

    $response = $this->actingAs($user)->patch('/api/v1/roles/'.$role1->id, [
        'name' => 'anotherRole',
    ]);

    $response->assertStatus(403);
});

it('allows to update role with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $role1 = Role::create(['name' => 'newRole']);

    $response = $this->actingAs($user)->patch('/api/v1/roles/'.$role1->id, [
        'name' => 'anotherRole',
    ]);

    $response->assertStatus(200);
});

it('does not allow to delete role without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $role1 = Role::create(['name' => 'newRole']);

    $response = $this->actingAs($user)->delete('/api/v1/roles/'.$role1->id);

    $response->assertStatus(403);
});

it('allows to delete role with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $role1 = Role::create(['guard_name' => 'api', 'name' => 'newRole']);

    $response = $this->actingAs($user)->delete('/api/v1/roles/'.$role1->id);

    $response->assertStatus(200);
});
