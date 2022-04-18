<?php

namespace Costa\Core\UseCases\Category\DTO\Category;

class CategoryList
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
