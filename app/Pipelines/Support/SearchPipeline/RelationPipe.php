<?php

namespace App\Pipelines\Support\SearchPipeline;

use Closure;
use Illuminate\Support\Arr;

class RelationPipe
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

        if (!$this->hasRelations()) return $builder;

        $relations = [];

        foreach (Arr::get($this->searchCriteria, 'relations') as $relation) {
            array_push($relations, $relation);
        }

        return $builder->with($relations);
    }

    /**
     * Identify if relations exists.
     * 
     * @return bool
     */
    private function hasRelations()
    {
        return Arr::has($this->searchCriteria, 'relations') && count(Arr::get($this->searchCriteria, 'relations'));
    }
}
