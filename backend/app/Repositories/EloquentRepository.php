<?php

namespace App\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class EloquentRepository implements RepositoryInterface
{
    protected array $collection;
    protected Model $model;
    protected string $modelName;

    public function setCollectionName(string $collectionName): void
    {
        $this->modelName = "App\\Models\\" . ucfirst($collectionName);

        if (false === class_exists($this->modelName)) {
            throw new Exception("Class {$this->modelName} doesn't exists");
        }

        $modelName = $this->modelName;

        $this->model = new $modelName();
    }

    public function save(object $entity): array
    {
        try{
            $model = new $this->model((array)$entity);
            $model->save();
            $model = $model->toArray();
            return $model;
        }catch(Exception $ex){
            throw new Exception("Error while persisting data.");
        }
    }

    public function find(int $id): array
    {
        $model = $this->model->findOrFail($id)->toArray();
        return $model;
    }

    public function update(int $id, object $entity): array
    {
        $model = $this->model->findOrFail($id);
        if($model->update(array_filter((array)$entity))){
            $model = $model->toArray();
            return $model;
        }
        throw new Exception("Error while updating data.");
    }

    public function delete(int $id): bool
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }

    public function list(array $params): Paginator
    {
        $query = $this->modelName::query();
        
        $query->when(request()->input('filter_value'), function ($query, $value) {
            return $query
            ->orwhereHas('legalEntity', function ($query) use($value) {
                $query->where(request()->input('filter_by'), 'like', '%' . $value . '%');
            })->orderBy(request()->input('order_by'), request()->input('direction'))
            ->orWhereHas('person', function ($query) use($value) {
                $query->where(request()->input('filter_by'), 'like', '%' . $value . '%');
            })->orderBy(request()->input('order_by'), request()->input('direction'));
        });
        
        return $query->paginate(15)->withQueryString();
    }

}