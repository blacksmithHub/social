<?php

namespace App\Services\Contracts;

interface ServiceInterface
{
    /**
     * Repository instance of the service.
     * 
     * @return \App\Repositories\Contracts\RepositoryInterface
     */
    public function repository();

    /**
     * Format the response for API collection.
     *
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Support\LazyCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator $data
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\LazyCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function setResponseCollection($data);

    /**
     * Format the response for API resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Database\Eloquent\Model
     */
    public function setResponseResource($data);
}
