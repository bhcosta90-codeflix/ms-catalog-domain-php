<?php

namespace Costa\Core\Domains\Repositories;

use Costa\Core\Domains\Entities\Category as Entity;

interface CategoryRepositoryInterface
{
    public function insert(Entity $entity): Entity;
    public function findById(string $id): Entity;
    public function findAll(array $filters = []): PaginationInterface;
    public function paginate(array $filters = [], int $page = 1, $totalPage = 15): PaginationInterface;
    public function update(Entity $entity): Entity;
    public function delete(Entity $entity): bool;
}
