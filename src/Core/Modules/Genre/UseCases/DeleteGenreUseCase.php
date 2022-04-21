<?php

namespace Costa\Core\Modules\Genre\UseCases;

use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface;

final class DeleteGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository
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
