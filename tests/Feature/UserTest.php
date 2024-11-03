<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->createUser();
    }

    public function test_register_user()
    {
        $data = [
            'name' => 'Matheus Oliveira',
            'email' => 'matheus@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }

    public function test_register_user_with_invalid_password()
    {
        $data = [
            'name' => 'Matheus Oliveira',
            'email' => 'matheus@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password1234',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('password');
        $this->assertDatabaseMissing('users', [
            'email' => $data['email'],
        ]);
    }

    public function test_register_user_with_invalid_email()
    {
        $data = [
            'name' => 'Matheus Oliveira',
            'email' => 'matheus',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
        $this->assertDatabaseMissing('users', [
            'email' => $data['email'],
        ]);
    }

    public function test_login_user_with_valid_credentials()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'message' => 'Success',
            'token' => $response['token'],
        ]);

    }

    public function test_login_user_with_invalid_credentials()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(401);
    }

    private function createUser(): void
    {
        $this->user = User::factory()->create();
    }
}
