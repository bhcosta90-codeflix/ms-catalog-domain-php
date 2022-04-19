<?php

namespace Costa\Core\UseCases\Genre;

use Costa\Core\Domains\Exceptions\NotFoundDomainException;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\UseCases\Contracts\TransactionContract;
use Throwable;

final class UpdateGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository,
        private TransactionContract $transactionContract,
        private CategoryRepositoryInterface $categoryRepositoryInterface,
    ) {
        //
    }

    public function execute(DTO\Updated\Input $input): DTO\Updated\Output
    {
        try {
            $repo = $this->repository->findById($input->id);

            $input->isActive !== null ? ($input->isActive ? $repo->enable() : $repo->disable()) : null;

            $repo->update(
                name: $input->name,
            );

            $categoryUpdated = $this->repository->update($repo);

            $this->validateCategories($input->categories);

            $this->transactionContract->commit();

            return new DTO\Updated\Output(
                id: $categoryUpdated->id,
                name: $categoryUpdated->name,
                isActive: $categoryUpdated->isActive,
                created_at: $categoryUpdated->createdAt(),
                updated_at: $categoryUpdated->updatedAt(),
            );
        } catch (Throwable $e) {
            throw $e;
        }
    }

    private function validateCategories(array $ids = [])
    {
        $categoriesDb = $this->categoryRepositoryInterface->getIds($ids);

        // if (count($ids) !== count($categoriesDb)) {
        //     throw new NotFoundDomainException("Total category this different");
        // }

        $arrayDiff = array_diff($categoriesDb, $ids) ?: array_diff($ids, $categoriesDb);

        if (count($arrayDiff)) {
            $msg = sprintf(
                '%s %s not found',
                count($arrayDiff) > 1 ? 'Categories' : 'Category',
                implode(', ', $arrayDiff)
            );
            throw new NotFoundDomainException($msg);
        }
    }
}
