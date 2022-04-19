<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;

final class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\CreatedCategory\Input $input): DTO\CreatedCategory\Output
    {
        $category = new Category(
            name: $input->name,
            description: $input->description,
            isActive: $input->isActive,
        );

        $newRepository = $this->repository->insert($category);
        return new DTO\CreatedCategory\Output(
            id: $newRepository->id(),
            name: $newRepository->name,
            description: $newRepository->description,
            isActive: $newRepository->isActive,
            createdAt: $newRepository->createdAt(),
            updatedAt: $newRepository->createdAt(),
        );
    }
}
