<?php

namespace Costa\Core\Modules\Category\UseCases;

use Costa\Core\Modules\Category\Entities\Category;
use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface;

final class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Created\Input $input): DTO\Created\Output
    {
        $category = new Category(
            name: $input->name,
            description: $input->description,
            isActive: $input->isActive,
        );

        $newRepository = $this->repository->insert($category);
        return new DTO\Created\Output(
            id: $newRepository->id(),
            name: $newRepository->name,
            description: $newRepository->description,
            is_active: $newRepository->isActive,
            created_at: $newRepository->createdAt(),
            updated_at: $newRepository->createdAt(),
        );
    }
}
