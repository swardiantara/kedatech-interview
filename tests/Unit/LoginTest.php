<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class LoginTest extends TestCase
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

    public function testValidationError() {
        $response = $this->postJson('/api/auth/login', [
            "email" => "wrong_formatted_emai.com",
            "password" => "password"
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure([
                "code",
                "status",
                "message" => [
                    "email"
                ],
                "data" => [
                    "email"
                ]
            ]);
    }

    public function testUserNotFound() {
        $response = $this->postJson('/api/auth/login', [
            "email" => "customer3@gmail.com",
            "password" => "dummydummy"
        ]);

        $response->assertStatus(404)
            ->assertJson([
                "code" => 404,
                "status" => "fail",
                "message" => "User not found"
            ]);
    }

    public function testCredentialsError() {
        $response = $this->postJson('/api/auth/login', [
            "email" => "customer1@gmail.com",
            "password" => "dummydummy2"
        ]);

        $response->assertStatus(401)
            ->assertJson([
                "code" => 401,
                "status" => "fail",
                "message" => "Invalid email/password",
                "data" => [
                    "email" => "customer1@gmail.com"
                ]
            ]);
    }

    public function testLoggedInSuccessfully() {
        $response = $this->postJson('/api/auth/login', [
            "email" => "customer1@gmail.com",
            "password" => "dummydummy"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "message",
                "data" => [
                    "access_token",
                    "token_type",
                    "expires_in",
                    "user"
                ]
            ]);
    }
}
