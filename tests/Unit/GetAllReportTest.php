<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;

class GetAllReportTest extends TestCase
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

    public function testCustomerCannotAccessReportsData()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/reports');

        $response->assertStatus(403)
            ->assertJson([
                "code" => 403,
                "status" => "fail",
                "message" => "Reports data is confidential to non-Staff users"
            ]);
    }

    public function testReportsDataFound()
    {
        $user = User::find(3); //staff
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/reports');

        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "message",
                "data" => [
                    "totalItems",
                    "reports" => [
                        ["id",
                        "reporter_id",
                        "type",
                        "description",
                        "created_at",
                        "updated_at"]
                    ]
                ]
            ]);
    }
}
