<?php

use App\Models\Permission;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('does not allow to view all permissions without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions');

    $response->assertStatus(403);
});

it('allows to view all permissions with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions');

    $response->assertStatus(200);
});

it('does not allow to view single permission without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions/1');

    $response->assertStatus(403);
});

it('allows to view single permission with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->get('/api/v1/permissions/1');

    $response->assertStatus(200);
});

it('does not allow to store new permission without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->post('/api/v1/permissions', [
        'name' => 'newPermission',
    ]);

    $response->assertStatus(403);
});

it('allows to store new permissions with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $response = $this->actingAs($user)->postJson('/api/v1/permissions', [
        'name' => 'newPermission',
    ]);

    $response->assertStatus(201);
});

it('does not allow to update permissions without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $permissions1 = Permission::create(['name' => 'newPermission']);

    $response = $this->actingAs($user)->patch('/api/v1/permissions/'.$permissions1->id, [
        'name' => 'anotherPermission',
    ]);

    $response->assertStatus(403);
});

it('allows to update permissions with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $permissions1 = Permission::create(['name' => 'newPermission']);

    $response = $this->actingAs($user)->patch('/api/v1/permissions/'.$permissions1->id, [
        'name' => 'anotherPermission',
    ]);

    $response->assertStatus(200);
});

it('does not allow to delete permissions without proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'customer@example.com')->first(),
        ['*'],
    );

    $permissions1 = Permission::create(['name' => 'newPermission']);

    $response = $this->actingAs($user)->delete('/api/v1/permissions/'.$permissions1->id);

    $response->assertStatus(403);
});

it('allows to delete permissions with proper permission', function () {
    $user = Sanctum::actingAs(
        User::where('email', 'admin@example.com')->first(),
        ['*'],
    );

    $permissions1 = Permission::create(['guard_name' => 'api', 'name' => 'newPermission']);

    $response = $this->actingAs($user)->delete('/api/v1/permissions/'.$permissions1->id);

    $response->assertStatus(200);
});
