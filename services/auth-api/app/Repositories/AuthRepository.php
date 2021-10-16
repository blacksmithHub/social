<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Support\Auth\AuthRequest;
use Laravel\Passport\{
    RefreshTokenRepository,
    TokenRepository
};

class AuthRepository extends Repository implements AuthRepositoryInterface
{
    /**
     * Create the repository instance.
     *
     * @param \App\Models\Auth
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Authenticate User
     *
     * @param string $email
     * @param string $password
     * @return Collection
     */
    public function authenticate(String $email, String $password)
    {
        return collect(
            (new AuthRequest)->getToken($email, $password)
        );
    }

    /**
     * Logout the user
     *
     * @return mixed
     */
    public function logout()
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenId = request()->user()->token()->id;

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return response()->json(true);
    }

    /**
     * Refresh the user token
     *
     * @param String $token
     * @return mixed
     */
    public function refreshToken(String $token)
    {
        return collect(
            (new AuthRequest)->getTokenViaRefreshToken($token)
        );
    }
}
