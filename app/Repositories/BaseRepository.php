<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->query()->select($columns)->paginate($perPage);
    }

    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->query()->select($columns)->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update(Model $model, array $attributes): bool
    {
        return $model->update($attributes);
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }
}

