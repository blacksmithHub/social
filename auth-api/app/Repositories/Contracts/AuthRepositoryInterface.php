<?php

namespace App\Repositories\Contracts;

interface AuthRepositoryInterface
{
    /**
     * Authenticate User
     * 
     * @param String $email
     * @param String $password
     * @return mixed
     */
    public function authenticate($email, $password);

    /**
     * Logout the user
     *
     * @return mixed
     */
    public function logout();

    /**
     * Refresh user token
     *
     * @param String $token
     * @return mixed
     */
    public function refreshToken($token);

    /**
     * Attempt to authorize user
     * 
     * @param String $email
     * @param String $password
     * @return bool
     */
    public function isValidCredential($email, $password);
}
