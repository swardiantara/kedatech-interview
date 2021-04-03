<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class GetConversationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     *
     * public function test_example()
     * {
     *    $this->assertTrue(true);
     * }
     */    

    public function testCustomerReceiverIsNotFound()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/customers/conversation/10');

        $response->assertStatus(404)
            ->assertJson([
                "code" => 404,
                "status" => "fail",
                "message" => "Receiver user not found",
            ]);
    }

    public function testNoCustomerMessagesFound()
    {
        $user = User::find(2); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/customers/conversation/3');

        $response->assertStatus(404)
            ->assertJson([
                "code" => 404,
                "status" => "fail",
                "message" => "no messages found",
            ]);
    }

    public function testSenderAndReceiverAreTheSame()
    {
        $user = User::find(2); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/customers/conversation/2');

        $response->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "status" => "fail",
                "message" => "Receiver's and sender's id are the same",
            ]);
    }

    public function testCustomerMessagesFound()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/customers/conversation/2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "message",
                "data" => [
                    [
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
