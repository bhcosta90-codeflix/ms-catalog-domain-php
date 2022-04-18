<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;

final class UpdateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Category\CategoryFind\Input $obj): DTO\Category\CategoryFind\Output
    {
        $repo = $this->repository->findById($obj->id);

        return new DTO\Category\CategoryFind\Output(
            id: $repo->id,
            name: $repo->name,
            description: $repo->description,
            isActive: $repo->isActive
        );
    }
}
