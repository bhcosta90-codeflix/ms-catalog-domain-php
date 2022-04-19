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

    public function execute(DTO\UpdatedCategory\Input $input): DTO\UpdatedCategory\Output
    {
        $repo = $this->repository->findById($input->id);

        $input->isActive !== null ? ($input->isActive ? $repo->enable() : $repo->disable()) : null;

        $repo->update(
            name: $input->name,
            description: $input->description ?? $repo->description
        );

        $categoryUpdated = $this->repository->update($repo);

        return new DTO\UpdatedCategory\Output(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            isActive: $categoryUpdated->isActive,
            createdAt: $categoryUpdated->createdAt(),
            updatedAt: $categoryUpdated->updatedAt(),
        );
    }
}
