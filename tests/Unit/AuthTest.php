<?php

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);
$authService = new \App\Services\AuthService();



it('cant login with invalid email', function () {

    $login_data = ['email' => 'user@example.com'.rand(2,9000009), 'password' => 'password'];
    $response = $this->postJson('/api/v1/auth/login', $login_data);

    $response->assertStatus(422);
});


it('cant login with unverified email address', function () use($authService) {
    $attributes = User::factory()->create(
    [
        'email_verified_at' => NULL,
    ]);

    $login_data = ['email' => $attributes['email'], 'password' => 'password'];
    $response = $this->postJson('/api/v1/auth/login', $login_data);

    $response->assertStatus(400)->assertJson(['message' => 'Your email hasn\'t been verified. We have resent the verification email. Please check your email to verify.']);
    $this->assertDatabaseHas('users', ["email" => $attributes['email']]);
});

it('cant login with invalid credentials', function () {
    $attributes = User::factory()->create(
    [
        'email_verified_at' => '2022-01-11 18:11:10',
    ]);

    $login_data = ['email' => $attributes['email'], 'password' => 'Password11'];
    $response = $this->postJson('/api/v1/auth/login', $login_data);

    $response->assertStatus(400)->assertJson(['message' => 'These credentials do not match our records.']);
    $this->assertDatabaseHas('users', ["email" => $attributes['email']]);
});


it('can login with verified email address', function () {
    $attributes = User::factory()->create(
    [
        'email_verified_at' => '2022-01-11 18:11:10',
    ]);

    $login_data = ['email' => $attributes['email'], 'password' => 'password'];
    $response = $this->postJson('/api/v1/auth/login', $login_data);

    $response->assertStatus(200)->assertJson(['message' => 'Login successfully.']);
    $this->assertDatabaseHas('users', ["email" => $attributes['email']]);
});

