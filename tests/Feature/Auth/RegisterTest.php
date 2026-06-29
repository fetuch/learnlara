<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('displays register form on the register page', function () {
    $response = $this->get(route('register'));

    $this->assertGuest();
    $response->assertStatus(200);
    $response->assertSee('Zarejestruj się');
});

it('creates a user', function () {
    $payload = [
        'name' => 'User Name',
        'email' => 'email@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $response = $this->post(route('register'), $payload);

    $this->assertDatabaseHas('users', [
        'name' => $payload['name'],
        'email' => $payload['email'],
    ]);

    $user = User::whereEmail($payload['email'])->first();

    expect(Hash::check($payload['password'], $user->fresh()->password))->toBeTrue();
    $this->assertAuthenticated();
    $response->assertRedirect(route('transactions.index'));
    $response->assertSessionHas('success');
});

it('rejects invalid data', function (array $invalidData, string $errorField) {
    $payload = [
        'name' => 'User Name',
        'email' => 'unique@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    // tworzymy jakiegoś usera
    User::factory()->create(['email' => 'taken@example.com']);

    // nadpisujemy payload danymi z datasetu
    $response = $this->post(route('register'), array_merge($payload, $invalidData));

    $response->assertInvalid([$errorField]);
})->with([
    'brak name' => [['name' => ''], 'name'],
    'email zajęty' => [['email' => 'taken@example.com'], 'email'],
    'password' => [['password' => 'short'], 'password'],
]);
