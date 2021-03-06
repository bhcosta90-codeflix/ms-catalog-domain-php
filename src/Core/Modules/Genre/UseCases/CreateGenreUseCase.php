<?php

namespace Costa\Core\Modules\Genre\UseCases;

use Costa\Core\Modules\Genre\Entities\Genre;
use Costa\Core\Utils\Exceptions\NotFoundDomainException;
use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface;
use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface;
use Costa\Core\Utils\Contracts\TransactionInterface;
use Throwable;

final class CreateGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository,
        private TransactionInterface $transactionInterface,
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

            if ($input->categories !== null) {
                $this->validateCategories($input->categories);
            }

            $genre = $this->repository->insert($objGenre);

            $this->transactionInterface->commit();

            return new DTO\Created\Output(
                id: $genre->id(),
                name: $genre->name,
                is_active: $genre->isActive,
                created_at: $genre->createdAt(),
                updated_at: $genre->createdAt(),
            );
        } catch (Throwable $e) {
            $this->transactionInterface->rollback();
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
