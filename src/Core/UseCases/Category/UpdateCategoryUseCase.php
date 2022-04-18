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

    public function execute(DTO\Category\CategoryDto $obj): DTO\Category\CategoryOutput
    {
        $repo = $this->repository->findById($obj->id);

        return new DTO\Category\CategoryOutput(
            id: $repo->id,
            name: $repo->name,
            description: $repo->description,
            isActive: $repo->isActive
        );
    }
}
