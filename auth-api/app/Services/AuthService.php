<?php

namespace App\Services;

use Illuminate\Support\Arr;

use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Services\Contracts\AuthServiceInterface;

class AuthService extends Service implements AuthServiceInterface
{
    /**
     * Create the service instance and inject its repository.
     *
     * @param App\Repositories\Contracts\AuthRepositoryInterface
     */
    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Login Action
     *
     * @param array $request
     * @return mixed
     */
    public function login($request)
    {
        return $this->repository->authenticate(
            Arr::get($request, 'email'),
            Arr::get($request, 'password')
        );
    }

    /**
     * Logout Action
     *
     * @param array $request
     * @return mixed
     */
    public function logout($request)
    {
        return $this->repository->logout();
    }

    /**
     * Refresh token action
     *
     * @param array $request
     * @return mixed
     */
    public function refreshToken($request)
    {
        return $this->repository->refreshToken(Arr::get($request, 'refresh_token'));
    }
}
