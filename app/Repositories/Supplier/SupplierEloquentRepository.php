<?php

namespace App\Repositories\Supplier;

use App\Models\Address;
use App\Models\Supplier;
use App\Models\Telephone;
use App\Repositories\BaseQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class SupplierEloquentRepository implements SupplierRepositoryInterface
{
    use BaseQueryBuilder;

    /**
     * @var string
     */
    private string $model = Supplier::class;
    /**
     * @var array|string[]
     */
    private array $includes = ['addresses', 'telephones'];
    /**
     * @var array|string[]
     */
    private array $sort = ['company_name', 'created_at'];
    /**
     * @var array|string[]
     */
    private array $filter = ['trading_name', 'company_name', 'registration_number'];

    /**
     * @param array $params
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(array $params = [], int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        $key = 'suppliers.' . (!empty($params) ? serialize($params) . '.' : '') . $perPage . '.' . $page;

        if (!Cache::has($key)) {
            $suppliers = $this->baseQuery()
                ->paginate(
                    perPage: $perPage,
                    page: $page
                )->appends(
                    request()->query()
                );

            Cache::put($key, $suppliers, 60 * 3);
        }

        return Cache::get($key);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return false|Model|mixed|null
     */
    public function update($id, array $attributes)
    {
        $supplier = $this->find($id);
        $supplier->update($attributes);
        $supplier->refresh();

        return $supplier;
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function delete($id)
    {
        try {
            return $this->find($id)->delete();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @return Collection<Supplier>
     */
    public function all(): Collection
    {
        return $this->get(request()->query());
    }

    /**
     * @param array $params
     * @return Collection<Supplier>
     */
    public function get(array $params)
    {
        return $this->baseQuery()
            ->get()
            ->append($params);
    }

    /**
     * @param $id
     * @return Model<Supplier>|null
     */
    public function find($id)
    {
        $key = 'suppliers.' . $id . (!empty(request()->query()) ? '.' . serialize(request()->query()) : '');
       // dd(request()->query());

        if (!Cache::has($key)) {
            $supplier = $this->baseQuery()
                ->findOrFail($id);

            Cache::put($key, $supplier, 60 * 3);
        }

        return Cache::get($key);
    }

    /**
     * @param array $attributes
     * @return Model<Supplier>
     */
    public function create(array $attributes)
    {
        return Supplier::create($attributes);
    }

    /**
     * @param Supplier $supplier
     * @param array $params
     * @return Model<Address>
     */
    public function addAddress(Supplier $supplier, array $params)
    {
        return $supplier->addresses()->create($params);
    }

    /**
     * @param Supplier $supplier
     * @param $addressId
     * @return int
     */
    public function removeAddress(Supplier $supplier, $addressId)
    {
        return $supplier->addresses()->detach($addressId);
    }

    /**
     * @param Supplier $supplier
     * @param array $params
     * @return Model<Telephone>
     */
    public function addTelephone(Supplier $supplier, array $params)
    {
        return $supplier->telephones()->create($params);
    }

    /**
     * @param Supplier $supplier
     * @param $addressId
     * @return int
     */
    public function removeTelephone(Supplier $supplier, $addressId)
    {
        return $supplier->telephones()->detach($addressId);
    }
}
