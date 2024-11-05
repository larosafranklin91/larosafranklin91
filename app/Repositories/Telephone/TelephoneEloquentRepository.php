<?php

namespace App\Repositories\Telephone;

use App\Exceptions\NotFoundException;
use App\Models\Telephone;
use App\Repositories\Address\AddressRepositoryInterface;
use App\Repositories\BaseQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class TelephoneEloquentRepository implements AddressRepositoryInterface
{
    use BaseQueryBuilder;

    private string $model = Telephone::class;

    private array $filter = ['number'];

    public function get(array $params)
    {
        $key = 'telephones.' . (!empty($params) ? serialize($params) . '.' : '');

        if (!Cache::has($key)) {
            $telephones = $this
                ->baseQuery()
                ->get()
                ->appends($params);

            Cache::put($key, $telephones, 60 * 3);
        }

        return Cache::get($key);
    }

    public function find($id)
    {
        $key = 'telephones.' . $id . (!empty(request()->query()) ? '.' . serialize(request()->query()) : '');

        if (!Cache::has($key)) {
            $telephone = $this
                ->baseQuery()
                ->findOrFail($id);

            Cache::put($key, $telephone, 60 * 3);
        }

        return Cache::get($key);
    }

    public function create(array $attributes)
    {
        app($this->model)->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $telephone = $this->find($id);
        $telephone->update($attributes);
        $telephone->refresh();

        return $telephone;
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
        $key = 'telephones.' . (!empty($params) ? serialize($params) . '.' : '') . $perPage . '.' . $page;

        if (!Cache::has($key)) {
            $telephones = $this->baseQuery()
                ->paginate(
                    perPage: $perPage,
                    page: $page
                )->appends(
                    request()->query()
                );

            Cache::put($key, $telephones, 60 * 3);
        }

        return Cache::get($key);
    }
}
