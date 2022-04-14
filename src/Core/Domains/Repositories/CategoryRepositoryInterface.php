<?php

namespace Costa\Core\Domains\Repositories;

use Costa\Core\Domains\Entities\Category as Entity;

interface CategoryRepositoryInterface
{
    public function insert(Entity $entity): Entity;
    public function findById(string $id): Entity;
    public function findAll(array $filters = []): array;
    public function paginate(array $filters = [], int $page = 1, $totalPage = 15): array;
    public function update(Entity $entity): Entity;
    public function delete(Entity $entity): bool;
    public function toEntity(object $data): Entity;
}
