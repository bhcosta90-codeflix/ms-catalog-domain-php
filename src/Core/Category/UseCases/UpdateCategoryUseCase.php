<?php

namespace Costa\Core\Category\UseCases;

use Costa\Core\Category\Repositories\CategoryRepositoryInterface;

final class UpdateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Updated\Input $input): DTO\Updated\Output
    {
        $repo = $this->repository->findById($input->id);

        $input->isActive !== null ? ($input->isActive ? $repo->enable() : $repo->disable()) : null;

        $repo->update(
            name: $input->name,
            description: $input->description ?? $repo->description
        );

        $categoryUpdated = $this->repository->update($repo);

        return new DTO\Updated\Output(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            is_active: $categoryUpdated->isActive,
            created_at: $categoryUpdated->createdAt(),
            updated_at: $categoryUpdated->updatedAt(),
        );
    }
}
