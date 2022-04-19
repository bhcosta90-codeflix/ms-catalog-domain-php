<?php

namespace Costa\Core\UseCases\Genre\DTO\List;

class Input
{
    public function __construct(
        public array $filter = [],
        public string|null $orderColumn = null,
        public string $order = 'DESC',
        public int $page = 1,
        public int $totalPage = 15,
    ) {
        //
    }
}
