<?php

namespace App\Pipelines;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;

use App\Pipelines\Support\SearchPipeline\{
    FilterPipe,
    SortPipe,
    RelationPipe,
};

trait SearchPipeline
{
    /**
     * Available pipelines
     * 
     * @var array $pipes
     */
    protected $pipes = [
        FilterPipe::class,
        SortPipe::class,
        RelationPipe::class,
    ];

    /**
     * Search for specific resources in the database.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function search(array $request)
    {
        request()->merge(['search' => $request]);

        $data = app(Pipeline::class)
            ->send($this->model)
            ->through($this->pipes)
            ->thenReturn();

        if (Arr::get($request, 'take')) $data = $data->take(Arr::get($request, 'take'));

        if (Arr::get($request, 'random_order')) $data = $data->inRandomOrder();

        if (Arr::get($request, 'page_size')) return $data->paginate(Arr::get($request, 'page_size'));

        if (Arr::get($request, 'first')) return $data->first();

        $searchCriteria = Arr::get($request, 'search_criteria');

        return (Arr::has($searchCriteria, 'relations') && count(Arr::get($searchCriteria, 'relations'))) ?
            $data->get() :
            $data->cursor();
    }
}
