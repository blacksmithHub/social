<?php

namespace App\Pipelines\Support\SearchPipeline;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

class FilterPipe
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
     * @param mixed $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function execute($builder)
    {
        $this->searchCriteria = Arr::get(request()->search, 'search_criteria');

        return $builder->when($this->hasFilterGroups(), function (Builder $query) {
            return $this->filterGroupsQueryBuilder($query);
        });
    }

    /**
     * Identify if filter_groups exists.
     * 
     * @return bool
     */
    private function hasFilterGroups()
    {
        return Arr::get($this->searchCriteria, 'filter_groups') && count(Arr::get($this->searchCriteria, 'filter_groups'));
    }

    /**
     * Perform Where query builder.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function filterGroupsQueryBuilder(Builder $builder)
    {
        $queryBuilder = $builder;

        foreach (Arr::get($this->searchCriteria, 'filter_groups') as $filterGroup) {
            $queryBuilder = $queryBuilder->where(function (Builder $query) use ($filterGroup) {
                return $this->filtersQueryBuilder($query, $filterGroup);
            });
        }

        return $queryBuilder;
    }

    /**
     * Perform OrWhere query builder.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filterGroup
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function filtersQueryBuilder(Builder $builder, array $filterGroup)
    {
        $queryBuilder = $builder;

        foreach (Arr::get($filterGroup, 'filters') as $filter) {
            $conditionType = strtolower(Arr::get($filter, 'condition_type'));
            $common = config('constants.search_properties.condition_types.common');
            $special = config('constants.search_properties.condition_types.special');

            if (Arr::exists($special, $conditionType)) {
                switch ($conditionType) {
                    case Arr::get($special, 'in'):
                        $queryBuilder = $queryBuilder->orWhereIn(Arr::get($filter, 'field'), Arr::get($filter, 'value'));
                        break;

                    case Arr::get($special, 'nin'):
                        $queryBuilder = $queryBuilder->orWhereNotIn(Arr::get($filter, 'field'), Arr::get($filter, 'value'));
                        break;

                    case Arr::get($special, 'notnull'):
                        $queryBuilder = $queryBuilder->orWhereNotNull(Arr::get($filter, 'field'));
                        break;

                    case Arr::get($special, 'null'):
                        $queryBuilder = $queryBuilder->orWhereNull(Arr::get($filter, 'field'));
                        break;

                    case Arr::get($special, 'between'):
                        $queryBuilder = $queryBuilder->orWhereBetween(Arr::get($filter, 'field'), Arr::get($filter, 'value'));
                        break;
                }
            } else {
                $queryBuilder = $queryBuilder->orWhere(
                    Arr::get($filter, 'field'),
                    Arr::get($common, $conditionType) ?: '=',
                    Arr::get($filter, 'value')
                );
            }
        }

        return $queryBuilder;
    }
}
