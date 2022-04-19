<?php

namespace Costa\Core\UseCases\Genre;

use Costa\Core\Domains\Entities\Genre;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\UseCases\Contracts\TransactionContract;

final class CreateGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository,
        private TransactionContract $transactionContract,
        private CategoryRepositoryInterface $categoryRepositoryInterface,
    ) {
        //
    }

    public function execute(DTO\Created\Input $input): DTO\Created\Output
    {
        $category = new Genre(
            name: $input->name,
            isActive: $input->isActive,
        );

        $newRepository = $this->repository->insert($category);

        return new DTO\Created\Output(
            id: $newRepository->id(),
            name: $newRepository->name,
            isActive: $newRepository->isActive,
            createdAt: $newRepository->createdAt(),
            updatedAt: $newRepository->createdAt(),
        );
    }
}
