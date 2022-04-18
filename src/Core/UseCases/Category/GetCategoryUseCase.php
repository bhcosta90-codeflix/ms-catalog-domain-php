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

    public function execute(DTO\Category\FindCategory\Input $obj): DTO\Category\FindCategory\Output
    {
        $repo = $this->repository->findById($obj->id);

        return new DTO\Category\FindCategory\Output(
            id: $repo->id,
            name: $repo->name,
            description: $repo->description,
            isActive: $repo->isActive
        );
    }
}
