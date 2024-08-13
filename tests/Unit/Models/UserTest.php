<?php

declare(strict_types=1);

use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'name',
        'role',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'contact_id',
    ]);
});
