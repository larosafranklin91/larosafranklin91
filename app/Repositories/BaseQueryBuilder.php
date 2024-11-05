<?php

namespace App\Repositories;

use App\Models\Supplier;
use Spatie\QueryBuilder\QueryBuilder;

trait BaseQueryBuilder
{
    private function baseQuery()
    {
        if(!property_exists($this, 'model')){
            throw new \Exception('Model property not found');
        }

        return QueryBuilder::for($this->model)
            ->allowedIncludes($this->includes())
            ->allowedFilters($this->filters())
            ->allowedSorts($this->sorts());
    }

    private function includes():array
    {
        if(property_exists($this, 'includes')){
            return $this->includes;
        }

        return [];
    }

    private function filters():array
    {
        if(property_exists($this, 'filters')){
            return $this->filters;
        }

        return [];
    }

    private function sorts():array
    {
        if(property_exists($this, 'sorts')){
            return $this->sorts;
        }

        return [];
    }
}
