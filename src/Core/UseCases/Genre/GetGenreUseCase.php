<?php

namespace Costa\Core\UseCases\Genre;

use Costa\Core\Domains\Repositories\GenreRepositoryInterface;

final class GetGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\FindGenre\Input $input): DTO\FindGenre\Output
    {
        $repo = $this->repository->findById($input->id);

        return new DTO\FindGenre\Output(
            id: $repo->id,
            name: $repo->name,
            isActive: $repo->isActive,
            createdAt: $repo->createdAt(),
            updatedAt: $repo->updatedAt(),
        );
    }
}
