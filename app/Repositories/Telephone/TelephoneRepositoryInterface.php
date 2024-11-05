<?php

namespace App\Repositories\Telephone;

use App\Models\Telephone;
use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TelephoneRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param array $params
     * @return Collection<Telephone>
     */
    public function get(array $params);

    /**
     * @param $id
     * @return Model<Telephone>
     */
    public function find($id);

    /**
     * @param array $attributes
     * @return Model<Telephone>
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @param array $attributes
     * @return Model<Telephone>
     */
    public function update($id, array $attributes);

    /**
     * @param $id
     * @return Collection<Telephone>
     */
    public function all(): \Illuminate\Database\Eloquent\Collection;
}
