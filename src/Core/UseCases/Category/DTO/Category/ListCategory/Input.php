<?php

namespace Costa\Core\UseCases\Category\DTO\Category\ListCategory;

class Input
{
    public function __construct(
        public array $filter = [],
        public string $order = 'DESC',
        public int $page = 1,
        public int $totalPage = 15,
    ) {
        //
    }
}
