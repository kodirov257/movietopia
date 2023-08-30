<?php

namespace Feature\Api\Auth;

use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        Event::fake();

        $response = $this->postJson('/api/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        Event::assertDispatched(Registered::class);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertExactJson([
            'success' => true,
            'message' => 'A fresh verification link has been sent to your email address.',
        ]);
    }

    public function test_register_error_no_password(): void
    {
        $response = $this->postJson('/api/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'name' => 'TestUser',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertExactJson([
            'success' => false,
            'message' => 'User with this username, email or phone exists.',
            'errors' => [
                'password' => [
                    'The password field is required.'
                ],
            ],
        ]);
    }

    public function test_register_error_wrong_email(): void
    {

        $response = $this->postJson('/api/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'name' => 'TestUser',
            'email' => 'wrong-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertExactJson([
            'success' => false,
            'message' => 'User with this username, email or phone exists.',
            'errors' => [
                'email' => [
                    'The email field must be a valid email address.'
                ],
            ],
        ]);
    }

    public function test_register_error_existing_user(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'name' => 'TestUser',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertExactJson([
            'success' => false,
            'message' => 'User with this username, email or phone exists.',
            'errors' => [
                'email' => [
                    'The email has already been taken.'
                ],
            ],
        ]);
    }
}
