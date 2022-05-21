<?php

namespace Costa\Core\Modules\Genre\Repositories;

use Costa\Core\Utils\Contracts\PaginationInterface;
use Costa\Core\Modules\Genre\Entities\Genre as Entity;
use Costa\Core\Utils\Contracts\EntityInterface;

interface GenreRepositoryInterface
{
    public function insert(Entity $entity): EntityInterface;
    public function findById(string $id): EntityInterface;
    public function getIds(array $id = []): array;
    public function findAll(array $filters = [], string|null $orderColumn = null, string|null $order = null): array;
    public function paginate(
        ?array $filters = null,
        ?string $orderColumn = null,
        ?string $order = null,
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface;
    public function update(Entity $entity): EntityInterface;
    public function delete(Entity $entity): bool;
    public function toEntity(object $object): EntityInterface;
}
