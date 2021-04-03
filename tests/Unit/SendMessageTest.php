<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class SendMessageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testReceiverIsNotFound()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/messages', [
                "receiverId" => 10,
                "message" => "This is a sample message"
            ]);

        $response->assertStatus(404)
            ->assertJson([
                "code" => 404,
                "status" => "fail",
                "message" => "Receiver user not found",
            ]);
    }

    public function testCustomerCannotSendMessageToStaff()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/messages', [
                "receiverId" => 3,
                "message" => "This is a sample message"
            ]);

        $response->assertStatus(403)
            ->assertJson([
                "code" => 403,
                "status" => "fail",
                "message" => "customer can't send message to staff",
            ]);
    }

    public function testCannotSendMessageToMySelf()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/messages', [
                "receiverId" => 1,
                "message" => "This is a sample message"
            ]);

        $response->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "status" => "fail",
                "message" => "can't send message to yourself",
            ]);
    }

    public function testMessageSentSuccessfully()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/messages', [
                "receiverId" => 2,
                "message" => "This is a sample message"
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "message",
                "data" => [
                    "message" => [
                        "id",
                        "sender_id",
                        "message",
                        "receiver_id",
                        "created_at",
                        "updated_at"
                    ]
                ]
            ]);
    }
}
