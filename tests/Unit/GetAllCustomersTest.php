<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class GetAllCustomersTest extends TestCase
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

    public function testCustomerCannotAccessAllCustomersData()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/customers');

        $response->assertStatus(403)
            ->assertJson([
                "code" => 403,
                "status" => "fail",
                "message" => "Customers data is confidential to non-Staff users"
            ]);
    }

    public function testCustomersDataFound()
    {
        $user = User::find(3); //staff
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "message",
                "data" => [
                    ["id",
                    "user_type_id",
                    "email",
                    "created_at",
                    "updated_at",
                    "deleted_at"]
                ]
            ]);
    }
}
