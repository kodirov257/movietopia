<?php

namespace Feature\Api;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_correct_user_info(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/auth/me');

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message', 'data']);
        $response->assertExactJson([
            'success' => true,
            'message' => null,
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'email_verified' => $user->email_verified,
                'role' => $user->role,
                'status' => $user->status,
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'id' => $user->id,
            ],
        ]);
    }
}
