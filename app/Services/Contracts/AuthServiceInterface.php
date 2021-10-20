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
     * @param array $request
     * @return mixed
     */
    public function logout($request);

    /**
     * Refresh token action
     *
     * @param array $request
     * @return mixed
     */
    public function refreshToken($request);
}
