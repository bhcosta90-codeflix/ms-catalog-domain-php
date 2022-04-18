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

    public function execute(DTO\Category\DeletedCategory\Input $obj): DTO\Category\DeletedCategory\Output
    {
        $repo = $this->repository->findById($obj->id);
        $ret = $this->repository->delete($repo);

        return new DTO\Category\DeletedCategory\Output(
            success: $ret
        );
    }
}
