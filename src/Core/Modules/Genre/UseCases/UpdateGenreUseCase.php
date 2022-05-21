<?php

namespace Costa\Core\Modules\Genre\UseCases;

use Costa\Core\Utils\Exceptions\NotFoundDomainException;
use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface;
use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface;
use Costa\Core\Utils\Contracts\TransactionInterface;
use Throwable;

final class UpdateGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository,
        private TransactionInterface $TransactionInterface,
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

            foreach ($input->categories ?: [] as $category) {
                $repo->addCategory($category);
            }

            if ($input->categories !== null) {
                $this->validateCategories($input->categories);
            }

            $categoryUpdated = $this->repository->update($repo);
            $this->TransactionInterface->commit();

            return new DTO\Updated\Output(
                id: $categoryUpdated->id,
                name: $categoryUpdated->name,
                is_active: $categoryUpdated->isActive,
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
