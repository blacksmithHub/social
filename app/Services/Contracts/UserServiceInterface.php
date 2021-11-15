<?php

namespace App\Services\Contracts;

use App\Services\Support\BaseContracts\{
    StoreInterface as Store,
    ShowInterface as Show,
};

interface UserServiceInterface extends Store, Show
{
    /**
     * Here you insert custom functions.
     */
}
