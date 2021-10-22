<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Models\User;

class StoreTest extends TestCase
{
    use WithFaker;

    /**
     * Route of the API
     *
     * @var String
     */
    protected $route = '/api/v1/signup';

    /**
     * Test user store with valid params
     *
     * @return void
     */
    public function test_valid_store()
    {
        $password = 'password';

        $params = User::factory()->make()->toArray();

        Arr::set($params, 'password', $password);
        Arr::set($params, 'password_confirmation', $password);

        $response = $this->json('POST', $this->route, $params);

        $response->assertStatus(201);
    }

    /**
     * Test user store with invalid params
     *
     * @return void
     */
    public function test_invalid_store()
    {
        $response = $this->json('POST', $this->route);

        $response->assertStatus(422);
    }
}
