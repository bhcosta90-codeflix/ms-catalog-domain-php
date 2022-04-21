<?php

namespace Costa\Core\Modules\Genre\UseCases;

use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface;

final class GetGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Find\Input $input): DTO\Find\Output
    {
        $repo = $this->repository->findById($input->id);

        return new DTO\Find\Output(
            id: $repo->id,
            name: $repo->name,
            is_active: $repo->isActive,
            created_at: $repo->createdAt(),
            updated_at: $repo->updatedAt(),
        );
    }
}
