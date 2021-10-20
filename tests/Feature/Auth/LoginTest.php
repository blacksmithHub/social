<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Models\User;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * Route of the API
     *
     * @var String
     */
    protected $route = '/api/v1/login';

    /**
     * Test login with valid credentials
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $params = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->json('POST', $this->route, $params);

        $response->assertOk();
    }

    /**
     * Test login with invalid credentials
     *
     * @return void
     */
    public function test_invalid_login()
    {
        $user = User::factory()->create();

        $params = [
            'email' => $user->email,
            'password' => 'wrong_password'
        ];

        $response = $this->json('POST', $this->route, $params);

        $response->assertStatus(422);
    }
}
