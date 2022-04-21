<?php

namespace Costa\Core\Modules\CastMember\Repositories;

use Costa\Core\Modules\CastMember\Entities\CastMember as Entity;
use Costa\Core\Utils\Contracts\PaginationInterface;

interface CastMemberRepositoryInterface
{
    public function insert(Entity $entity): Entity;
    public function findById(string $id): Entity;
    public function getIds(array $id = []): array;
    public function findAll(array $filters = [], string|null $orderColumn = null, string|null $order = null): array;
    public function paginate(
        array $filters = [],
        string|null $orderColumn = null,
        string|null $order = null,
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface;
    public function update(Entity $entity): Entity;
    public function delete(Entity $entity): bool;
    public function toEntity(object $object): Entity;
}
