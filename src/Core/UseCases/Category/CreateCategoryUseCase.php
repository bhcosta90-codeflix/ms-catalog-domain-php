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

    public function execute(DTO\Category\CategoryCreated\Input $repo): DTO\Category\CategoryCreated\Output
    {
        $category = new Category(
            name: $repo->name,
            description: $repo->description,
            isActive: $repo->isActive,
        );

        $newRepository = $this->repository->insert($category);
        return new DTO\Category\CategoryCreated\Output(
            id: $newRepository->id(),
            name: $newRepository->name,
            description: $newRepository->description,
            isActive: $newRepository->isActive,
        );
    }
}
