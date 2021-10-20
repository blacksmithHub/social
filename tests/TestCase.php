<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Authenticated user instance.
     * 
     * @var \App\Models\User;
     */
    protected $user;

    /**
     * Login as a user.
     * 
     * @return void
     */
    protected function actingAsUser()
    {
        $this->user = User::factory()->create();

        Passport::actingAs($this->user);
    }
}
