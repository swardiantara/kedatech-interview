<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;

// use PHPUnit\Framework\TestCase;

class GetAllMessageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $this->assertTrue(true);
    // }

    public function testCustomerCannotAccessChatHistory()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/messages');

        $response->assertStatus(403)
            ->assertJson([
                "code" => 403,
                "status" => "fail",
                "message" => "Chat history is confidential to non-Staff users"
            ]);
    }

    public function testMessagesDataFound()
    {
        $user = User::find(3); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/messages');

        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "message",
                "data" => [
                    "totalItems",
                    "messages" => [
                        ["id",
                        "sender_id",
                        "message",
                        "receiver_id",
                        "created_at",
                        "updated_at"]
                    ]
                ]
            ]);
    }
}
