<?php

namespace App\Services\Contracts;

interface AuthServiceInterface
{
    /**
     * Login Action
     *
     * @param array $request
     * @return mixed
     */
    public function login($request);

    /**
     * Logout Action
     *
     * @return mixed
     */
    public function logout();

    /**
     * Refresh token action
     *
     * @param array $request
     * @return mixed
     */
    public function refreshToken($request);

    /**
     * Get authenticated user
     * 
     * @return mixed
     */
    public function getAuth();
}
