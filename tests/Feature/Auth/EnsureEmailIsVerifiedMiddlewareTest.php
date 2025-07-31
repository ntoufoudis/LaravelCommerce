<?php

use App\Models\User;

it('can show message if not verified', function () {
    $user = User::factory()->unverified()->create();
    $response = $this->actingAs($user)
        ->get('/api/v1/me');

    $response->assertJson([
        'message' => 'Your email address is not verified.',
    ]);
});

it('cannot show message if verified', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/api/v1/me');

    $response->assertJsonMissing([
        'message' => 'Your email address is not verified.',
    ]);
});
