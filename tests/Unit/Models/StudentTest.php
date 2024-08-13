<?php

declare(strict_types=1);

use App\Models\Student;

test('to array', function () {
    $user = Student::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'firstname',
        'lastname',
        'birthdate',
        'gender',
        'created_at',
        'updated_at',   
    ]);
});
