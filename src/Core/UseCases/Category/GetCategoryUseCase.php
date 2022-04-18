<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\UseCases\Category\DTO\Category\CategoryOutput;

final class GetCategoryUseCase
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
