<?php

namespace App\Rules\Auth;

use Illuminate\Contracts\Validation\Rule;

use Facades\App\Repositories\Contracts\AuthRepositoryInterface as AuthRepository;
use Illuminate\Support\Facades\Auth;

class LoginRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return AuthRepository::isValidCredential(
            request()->email,
            request()->password
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email address or password does not match.';
    }
}
