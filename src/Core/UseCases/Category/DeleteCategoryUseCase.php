<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;

final class DeleteCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Category\CategoryDeleted\Input $obj): DTO\Category\CategoryDeleted\Output
    {
        $repo = $this->repository->findById($obj->id);
        $ret = $this->repository->delete($repo);

        return new DTO\Category\CategoryDeleted\Output(
            success: $ret
        );
    }
}
