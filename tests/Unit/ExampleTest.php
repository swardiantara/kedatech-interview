<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    // public function testLoginValidationError() {
    //     $response = $this->postJson('/api/auth/login', [
    //         "email" => "wrong_formatted_emai.com",
    //         "password" => "password"
    //     ]);

    //     $response->assertStatus(400)
    //         ->assertJson([
    //             "code" => 400,
    //             "status" => "fail",
    //             "message" => [],
    //             "data" => []
    //         ]);

    // }

    // public function testLoginUserNotFound() {
    //     $response = $this->postJson('/api/auth/login', [
    //         "email" => "customer3@gmail.com",
    //         "password" => "dummydummy"
    //     ]);

    //     $response->assertStatus(404)
    //         ->assertJson([
    //             "code" => 404,
    //             "status" => "fail",
    //             "message" => "User not found"
    //         ]);
    // }

    // public function testLoginCredentialsError() {
    //     $response = $this->postJson('/api/auth/login', [
    //         "email" => "customer1@gmail.com",
    //         "password" => "dummydummy2"
    //     ]);

    //     $response->assertStatus(401)
    //         ->assertJson([
    //             "code" => 401,
    //             "status" => "fail",
    //             "message" => "Invalid email/password",
    //             "data" => [
    //                 "email" => "customer1@gmail.com"
    //             ]
    //         ]);
    // }

    // public function testLoginSuccess() {
    //     $response = $this->postJson('/api/auth/login', [
    //         "email" => "customer1@gmail.com",
    //         "password" => "dummydummy"
    //     ]);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             "code" => 200,
    //             "status" => "success",
    //             "message" => "login successful",
    //             "data" => []
    //         ]);
    // }
}
