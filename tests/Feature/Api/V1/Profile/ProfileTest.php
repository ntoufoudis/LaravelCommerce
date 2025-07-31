<?php

use App\Models\User;

it('can show profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/api/v1/me');

    $response->assertStatus(200)
        ->assertJson([
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
        ]);
});

it('can replace profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->putJson('/api/v1/me', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
});

it('can update profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->patchJson('/api/v1/me', [
            'name' => 'John Doe',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'name' => 'John Doe',
            'email' => $user->email,
        ]);
});
