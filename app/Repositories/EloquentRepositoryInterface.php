<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * @template T of Model
     * @return Collection<T>
     */
    public function all():Collection;

    /**
     * @template T of Model
     * @param array $params
     * @return Collection<T>
     */
    public function get(array $params);

    /**
     * @template T of Model
     * @param $id
     * @return Model<T> | null
     */
    public function find($id);

    /**
     * @template T of Model
     * @param array $attributes
     * @return Model<T>
     */
    public function create(array $attributes);

    /**
     * @template T of Model
     * @param array $attributes
     * @return Model<T>
     */
    public function update($id, array $attributes);

    /**
     * @param $id
     * @return bool
     */
    public function delete($id);


    /**
     * @param array $params
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(array $params = [], int $perPage = 10, int $page=1):LengthAwarePaginator;
}
