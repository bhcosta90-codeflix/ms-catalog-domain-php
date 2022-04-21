<?php

namespace Costa\Core\Category\UseCases;

use Costa\Core\Category\Repositories\CategoryRepositoryInterface;

final class DeleteCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Deleted\Input $input): DTO\Deleted\Output
    {
        $repo = $this->repository->findById($input->id);
        $ret = $this->repository->delete($repo);

        return new DTO\Deleted\Output(
            success: $ret
        );
    }
}
