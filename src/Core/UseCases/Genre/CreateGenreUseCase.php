<?php

namespace Costa\Core\UseCases\Genre;

use Costa\Core\Domains\Entities\Genre;
use Costa\Core\Domains\Exceptions\NotFoundDomainException;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\UseCases\Contracts\TransactionContract;
use Throwable;

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
        try {
            $objGenre = new Genre(
                name: $input->name,
                isActive: $input->isActive,
                categories: $input->categories
            );

            $genre = $this->repository->insert($objGenre);

            if ($input->categories !== null) {
                $this->validateCategories($input->categories);
            }

            $this->transactionContract->commit();

            return new DTO\Created\Output(
                id: $genre->id(),
                name: $genre->name,
                isActive: $genre->isActive,
                created_at: $genre->createdAt(),
                updated_at: $genre->createdAt(),
            );
        } catch (Throwable $e) {
            $this->transactionContract->rollback();
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
