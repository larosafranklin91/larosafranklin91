<?php

namespace App\Repositories\Address;

use App\Models\Address;
use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AddressRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param array $params
     * @return Collection<Address>
     */
    public function get(array $params);

    /**
     * @param $id
     * @return Model<Address>
     */
    public function find($id);

    /**
     * @param array $attributes
     * @return Model<Address>
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @param array $attributes
     * @return Model<Address>
     */
    public function update($id, array $attributes);

    /**
     * @param $id
     * @return Collection<Address>
     */
    public function all(): \Illuminate\Database\Eloquent\Collection;
}
