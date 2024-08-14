<?php

use App\Models\User;

test('vertical menu displays correct items for different roles', function ($role, $expectedMenuItem = [], $unexpectedMenuItem = []) {
    $user = User::factory()->create([
        'role' => $role,
    ]);

    $response = $this->actingAs($user)
        ->view('layouts.navigation-vertical');
    
    if($expectedMenuItem)
    {
        foreach($expectedMenuItem as $item)
        {
            $response->assertSee($item);
        }
    }

    if($unexpectedMenuItem)
    {
        foreach($unexpectedMenuItem as $item)
        {
            $response->assertDontSee($item);
        }
    }
    
    })->with([
        ['admin', ['Dashboard', 'Bookmarks', 'Posts', 'Classrooms', 'Post Groups', 'Users', 'Students']],
        ['teacher', ['Dashboard', 'Bookmarks'], ['Classrooms', 'Post Groups', 'Users', 'Students']],
        ['personel', ['Dashboard', 'Bookmarks'], ['Classrooms', 'Post Groups', 'Users', 'Students']],
        ['parent', ['Dashboard', 'Bookmarks'], ['Posts', 'Classrooms', 'Post Groups', 'Users', 'Students']],
        ['student', ['Dashboard', 'Bookmarks'], ['Posts', 'Classrooms', 'Post Groups', 'Users', 'Students']],
        
]);