<?php

namespace App\Services\Support\Traits;

use Illuminate\Support\Arr;

trait RepositoryResource
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\LazyCollection|\Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index()
    {
        return $this->setResponseCollection(
            $this->repository->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(array $request)
    {
        return $this->setResponseResource(
            $this->repository->create($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int|string $id
     * @param bool $findOrFail
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function show($id, bool $findOrFail = true)
    {
        $data = $this->repository->find($id, $findOrFail);

        return isset($data)
            ? $this->setResponseResource($data)
            : null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int|string $id
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function update($id, array $request)
    {
        return $this->setResponseResource(
            $this->repository->update($id, $request)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|string $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Search for specific resources in the database.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\LazyCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function search(array $request)
    {
        $data = $this->repository->search($request);

        if (!isset($data)) return null;

        return Arr::get($request, 'first') ?
            $this->setResponseResource($data) :
            $this->setResponseCollection($data);
    }
}
