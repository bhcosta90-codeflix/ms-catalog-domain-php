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

    public function execute(DTO\Category\UpdatedCategory\Input $obj): DTO\Category\UpdatedCategory\Output
    {
        $repo = $this->repository->findById($obj->id);

        $repo->update(
            name: $obj->name,
            description: $obj->description ?? $repo->description
        );

        $categoryUpdated = $this->repository->update($repo);

        return new DTO\Category\UpdatedCategory\Output(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            isActive: $categoryUpdated->isActive
        );
    }
}
