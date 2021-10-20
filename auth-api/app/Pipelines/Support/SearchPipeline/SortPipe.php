<?php

namespace App\Pipelines\Support\SearchPipeline;

use Closure;
use Illuminate\Support\Arr;

class SortPipe
{
    /**
     * Defined search criteria
     * 
     * @var array $searchCriteria
     */
    private $searchCriteria;

    /**
     * Pipe Handler Method
     *
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param Closure $next
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle($model, Closure $next)
    {
        return $this->execute($next($model));
    }

    /**
     * Perform pipe.
     * 
     * @param mixed $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function execute($builder)
    {
        $this->searchCriteria = Arr::get(request()->search, 'search_criteria');

        if (!$this->hasSortOrders()) return $builder;

        foreach (Arr::get($this->searchCriteria, 'sort_orders') as $sort) {
            $builder = $builder->orderBy(
                Arr::get($sort, 'field'),
                strtolower(Arr::get($sort, 'direction'))
            );
        }

        return $builder;
    }

    /**
     * Identify if sort_orders exists.
     * 
     * @return bool
     */
    private function hasSortOrders()
    {
        return Arr::has($this->searchCriteria, 'sort_orders') && count(Arr::get($this->searchCriteria, 'sort_orders'));
    }
}
