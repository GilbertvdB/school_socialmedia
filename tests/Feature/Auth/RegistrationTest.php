<?php

use App\Models\PostGroup;
use App\Models\User;

test('registration screen can be rendered', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/register');

    $response->assertStatus(200);
});

test('admin can register new users', function () {
    $user = User::factory()->create();
    $groups = PostGroup::factory()->create();
    $response = $this->actingAs($user)->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'role' => 'personel',
        'post_groups' => [ $groups->id],
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/users');
});
