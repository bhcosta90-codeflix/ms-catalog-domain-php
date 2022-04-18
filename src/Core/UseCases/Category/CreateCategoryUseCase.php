<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;

final class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    )
    {
        //
    }

    public function execute(DTO\Category\CreatedCategory\Input $repo): DTO\Category\CreatedCategory\Output
    {
        $category = new Category(
            name: $repo->name,
            description: $repo->description,
            isActive: $repo->isActive,
        );

        $newRepository = $this->repository->insert($category);
        return new DTO\Category\CreatedCategory\Output(
            id: $newRepository->id(),
            name: $newRepository->name,
            description: $newRepository->description,
            isActive: $newRepository->isActive,
            createdAt: $newRepository->createdAt()
        );
    }
}
