<?php

namespace Costa\Core\Utils\Contracts;

use Costa\Core\Utils\Contracts\EntityInterface;
use Costa\Core\Utils\Contracts\PaginationInterface;

interface RepositoryInterface
{
    public function insert(EntityInterface $entity): EntityInterface;
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
    public function update(EntityInterface $entity): EntityInterface;
    public function delete(EntityInterface $entity): bool;
    public function toEntity(object $object): EntityInterface;
}
