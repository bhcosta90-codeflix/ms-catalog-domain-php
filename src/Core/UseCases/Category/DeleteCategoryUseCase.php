<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;

final class DeleteCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Category\CategoryFind\Input $obj): bool
    {
        $repo = $this->repository->findById($obj->id);
        return $this->repository->delete($repo);
    }
}
