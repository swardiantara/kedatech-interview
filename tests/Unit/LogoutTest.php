<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;

// use PHPUnit\Framework\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testLoggedOutSuccessfully()
    {
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")->postJson('/api/auth/logout');
        
        $response->assertStatus(200)
            ->assertJson([
                "code" => 200,
                'message' => 'User successfully signed out'
            ]);
    }

    public function testTokenIsInvalid()
    {
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}s")->postJson('/api/auth/logout');
        
        $response->assertStatus(401)
            ->assertJson([
                "code" => 401,
                "message" => "Token is Invalid"
            ]);
    }

    public function testTokenAbsent() {
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('/api/auth/logout');
        
        $response->assertStatus(401)
            ->assertJson([
                "code" => 401,
                "message" => "Authorization Token not found"
            ]);
    }
}
