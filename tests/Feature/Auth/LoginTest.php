<?php

use App\Models\User;

it('displays login form on the login page', function () {
    $response = $this->get(route('login'));

    $this->assertGuest();
    $response->assertStatus(200);
    $response->assertSee('Zaloguj się');
});

it('logs in a user', function () {
    $user = User::factory()->create([
        'email' => 'email@example.com',
        'password' => 'password',
    ]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('transactions.index'));
    $response->assertSessionHas('success');
});

it('rejects malformed email', function () {
    $response = $this->post(route('login'), [
        'email' => 'wrong email',
    ]);
    $response->assertInvalid(['email']);
    $this->assertGuest();
});

it('rejects wrong password', function () {
    $user = User::factory()->create([
        'email' => 'email@example.com',
        'password' => 'password',
    ]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong password',
    ]);
    $response->assertInvalid(['email']);
    $this->assertGuest();
});
