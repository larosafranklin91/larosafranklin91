<?php

namespace App\Repositories\Address;

use App\Exceptions\NotFoundException;
use App\Models\Address;
use App\Repositories\BaseQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AddressEloquentRepository implements AddressRepositoryInterface
{
    use BaseQueryBuilder;

    private string $model = Address::class;

    private array $filter = ['street', 'city', 'state', 'zip_code'];

    public function get(array $params)
    {
        $key = 'addresses.' . (!empty($params) ? serialize($params) . '.' : '');

        if (!Cache::has($key)) {
            $addresses = $this
                ->baseQuery()
                ->get()
                ->appends($params);

            Cache::put($key, $addresses, 60 * 3);
        }

        return Cache::get($key);
    }

    public function find($id)
    {
        $key = 'addresses.' . $id . (!empty(request()->query()) ? '.' . serialize(request()->query()) : '');

        if (!Cache::has($key)) {
            $address = $this
                ->baseQuery()
                ->findOrFail($id);

            Cache::put($key, $address, 60 * 3);
        }

        return Cache::get($key);
    }

    public function create(array $attributes)
    {
        app($this->model)->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $address = $this->find($id);
        $address->update($attributes);
        $address->refresh();

        return $address;
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->baseQuery()->get();
    }

    public function delete($id)
    {
        try {
            return $this->find($id)->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function paginate(array $params = [], int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        $key = 'addresses.' . (!empty($params) ? serialize($params) . '.' : '') . $perPage . '.' . $page;

        if (!Cache::has($key)) {
            $addresses = $this->baseQuery()
                ->paginate(
                    perPage: $perPage,
                    page: $page
                )->appends(
                    request()->query()
                );

            Cache::put($key, $addresses, 60 * 3);
        }

        return Cache::get($key);
    }
}
