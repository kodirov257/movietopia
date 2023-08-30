<?php

namespace Feature\Api\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_api(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email_or_username' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'token',
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email_or_username' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'success',
            'errors',
            'message',
        ]);
        $response->assertExactJson([
            'success' => false,
            'errors' => ['email_or_username' => ['These credentials do not match our records.']],
            'message' => 'These credentials do not match our records.',
        ]);
    }
}
