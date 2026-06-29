<?php

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('redirects guest user to login page', function () {
    Auth::logout();
    $this->assertGuest();
    $response = $this->get(route('transactions.index'));
    $response->assertRedirect(route('login'));
});

it('displays transactions on the index page', function () {
    // Arrange
    $title = 'Zakup akcji Torpol';
    Transaction::factory()->create(['title' => $title]);

    // Act
    $response = $this->get(route('transactions.index'));

    // Assert
    $response->assertStatus(200);
    $response->assertSee($title);
});

it('stores a new transaction', function () {
    // Arrange
    $title = 'Zakup akcji Torpol';

    // Act
    $response = $this->post(route('transactions.store'), [
        'title' => $title,
        'amount' => 10000,
        'occurred_on' => '2020-08-22',
        'type' => 'expense',
    ]);

    // Assert
    $this->assertDatabaseHas('transactions', [
        'title' => $title,
        'amount' => 10000,
    ]);
    $transaction = Transaction::firstWhere('title', $title);
    expect($transaction->occurred_on->toDateString())->toBe('2020-08-22');
    $response->assertRedirect(route('transactions.index'));
    $response->assertSessionHas('success');
});

it('requires a title', function () {
    // Act: POST bez title
    $response = $this->post(route('transactions.store'), [
        'amount' => 10000,
        'occurred_on' => '2020-08-22',
        'type' => 'expense',
    ]);

    // Assert
    $response->assertInvalid(['title']);
    $this->assertDatabaseCount('transactions', 0);
});

it('rejects invalid data', function (array $invalidData, string $errorField) {
    $payload = [
        'title' => 'OK',
        'amount' => 10000,
        'occurred_on' => '2020-08-22',
        'type' => 'expense',
    ];

    // nadpisujemy payload danymi z datasetu (np. usuwamy/psujemy jedno pole)
    $response = $this->post(route('transactions.store'), array_merge($payload, $invalidData));

    $response->assertInvalid([$errorField]);
})->with([
    'brak title' => [['title' => ''], 'title'],
    'amount = 0' => [['amount' => 0], 'amount'],          // masz min:1
    'zły type' => [['type' => 'transfer'], 'type'],     // masz Rule::in
    'zła data' => [['occurred_on' => 'not-a-date'], 'occurred_on'],
]);
