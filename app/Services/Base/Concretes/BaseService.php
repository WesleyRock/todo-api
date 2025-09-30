<?php

declare(strict_types=1);

namespace App\Services\Base\Concretes;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use App\Services\Base\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    protected QueryableRepositoryInterface $repository;

    final public function setRepository(QueryableRepositoryInterface $repository): QueryableRepositoryInterface
    {
        return $this->repository = $repository;
    }

    final public function getRepository(): QueryableRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * Get filtered, sorted, and included resources.
     */
    final public function getFiltered(array $columns = ['*']): Collection
    {
        return $this->repository->getFiltered($columns);
    }

    /**
     * Get all resources
     */
    final public function all(array $columns = ['*']): Collection
    {
        return $this->repository->all($columns);
    }

    /**
     * Get paginated resources
     */
    final public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * Find resource by id
     */
    final public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Find resource or fail
     */
    final public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->repository->findOrFail($id, $columns);
    }

    /**
     * Create new resource
     */
    final public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update resource
     */
    final public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete resource
     */
    final public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
