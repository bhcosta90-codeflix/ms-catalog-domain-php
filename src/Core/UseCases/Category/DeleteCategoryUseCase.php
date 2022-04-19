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

    public function execute(DTO\DeletedCategory\Input $input): DTO\DeletedCategory\Output
    {
        $repo = $this->repository->findById($input->id);
        $ret = $this->repository->delete($repo);

        return new DTO\DeletedCategory\Output(
            success: $ret
        );
    }
}
