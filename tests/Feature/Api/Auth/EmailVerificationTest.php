<?php

namespace Feature\Api\Auth;

use App\Models\User\User;
use App\Services\Auth\AuthenticationService;
use Carbon\Carbon;
use Google2FA;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();

        Event::fake();

        $response = $this->postJson('/api/verify-email', [
            'id' => $user->id,
            'hash' => $user->email_verify_token,
        ]);

        Event::assertDispatched(Verified::class);
        self::assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertJsonStructure(['success', 'message']);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Your e-mail is verified. You can now login.',
        ]);
    }

    public function test_email_is_already_verified(): void
    {
        $user = User::factory()->create();

        Event::fake();

        $response = $this->postJson('/api/verify-email', [
            'id' => $user->id,
            'hash' => $user->email_verify_token,
        ]);

        Event::assertNotDispatched(Verified::class);
        self::assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertJsonStructure(['success', 'message']);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Your e-mail is verified. You can now login.',
        ]);
    }

    public function test_email_can_not_be_verified_wrong_id(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/verify-email', [
            'id' => $user->id + 1,
            'hash' => $user->email_verify_token,
        ]);

        $response->assertJsonStructure(['success', 'message']);
        $response->assertExactJson([
            'success' => false,
            'message' => 'User with this email or phone not found.',
        ]);
        $response->assertStatus(401);
    }

    public function test_email_can_not_be_verified_expired_token(): void
    {
        $user = User::factory()->unverified()->create([
            'email_verify_token' => Str::uuid() . '_' . Carbon::now()->subDays(40)->format('Y-m-d-H:i:s'),
        ]);

        $response = $this->postJson('/api/verify-email', [
            'id' => $user->id,
            'hash' => $user->email_verify_token,
        ]);

        $response->assertJsonStructure(['success', 'message']);
        $response->assertExactJson([
            'success' => false,
            'message' => 'Token is expired.',
        ]);
        $response->assertStatus(422);
    }
}
