<?php

namespace App\Services\Support\BaseContracts;

interface SearchInterface
{
    /**
     * Search for specific resources in the database.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\LazyCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function search(array $request);
}
