<?php

uses()->group('home');

it('redirects to the login page', function () {
    $response = $this->get('/');
 
    $response->assertStatus(302);
    $response->assertRedirect('/login');
});