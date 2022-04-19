<?php

namespace Costa\Core\UseCases\Genre;

use Costa\Core\Domains\Repositories\GenreRepositoryInterface;

final class UpdateGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Updated\Input $input): DTO\Updated\Output
    {
        $repo = $this->repository->findById($input->id);

        $input->isActive !== null ? ($input->isActive ? $repo->enable() : $repo->disable()) : null;

        $repo->update(
            name: $input->name,
        );

        $categoryUpdated = $this->repository->update($repo);

        return new DTO\Updated\Output(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            isActive: $categoryUpdated->isActive,
            createdAt: $categoryUpdated->createdAt(),
            updatedAt: $categoryUpdated->updatedAt(),
        );
    }
}
