<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class CreateReportTest extends TestCase
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

    public function testValidationError()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/reports', [
                "type" => "vulnerability",
                "description" => "This is a sample description"
            ]);

        $response->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "status" => "fail",
                "message" => [],
                "data" => [
                    'type' => "vulnerability",
                    'description' => "This is a sample description",
                ]
            ]);
    }

    public function testReportCreatedSuccessfully()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/reports', [
                "type" => "bug",
                "description" => "This is a sample description of bug report"
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'code',
                'message',
                'result' => [
                    "id",
                    "reporter_id",
                    "type",
                    "description",
                    "created_at",
                    "updated_at"
                ]
            ]);
    }
}
