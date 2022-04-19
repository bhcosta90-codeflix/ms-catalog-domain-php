<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;

final class GetCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Find\Input $input): DTO\Find\Output
    {
        $repo = $this->repository->findById($input->id);

        return new DTO\Find\Output(
            id: $repo->id,
            name: $repo->name,
            description: $repo->description,
            isActive: $repo->isActive,
            created_at: $repo->createdAt(),
            updated_at: $repo->updatedAt(),
        );
    }
}
