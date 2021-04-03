<?php

namespace Tests\Unit;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tests\TestCase;

// use PHPUnit\Framework\TestCase;

class DeleteCustomerTest extends TestCase
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

    public function testCustomerCannotDeleteCustomersData()
    {
        $user = User::find(1); //Customer
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson('/api/customers/1');

        $response->assertStatus(403)
            ->assertJson([
                "code" => 403,
                "status" => "fail",
                "message" => "Non-staff users can't delete customer data"
            ]);
    }

    public function testCustomerDataNotFound()
    {
        $user = User::find(3); //staff
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson('/api/customers/5');

        $response->assertStatus(404)
            ->assertJson([
                "code" => 404,
                "status" => "fail",
                "message" => "customer data not found"
            ]);
    }

    // public function testCannotDeleteNonCustomerData()
    // {
    //     $user = User::find(3); //staff
    //     $token = JWTAuth::fromUser($user);

    //     $response = $this->withHeader('Authorization', "Bearer {$token}")
    //         ->deleteJson('/api/customers/4');

    //     $response->assertStatus(403)
    //         ->assertJson([
    //             "code" => 403,
    //             "status" => "fail",
    //             "message" => "deleting data is not customer data"
    //         ]);
    // }

    public function testCustomerDeletedSuccessfully()
    {
        $user = User::find(3); //staff
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson('/api/customers/2');

        $response->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "success",
                "message" => "customer deleted successfully"
            ]);
    }
}
