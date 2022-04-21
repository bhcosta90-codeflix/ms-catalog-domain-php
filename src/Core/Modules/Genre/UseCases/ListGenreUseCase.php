<?php

namespace Costa\Core\Modules\Genre\UseCases;

use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface;

class ListGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\List\Input $input): DTO\List\Output
    {
        $repo = $this->repository->paginate(
            filters: $input->filter,
            page: $input->page,
            totalPage: $input->totalPage,
        );

        return new DTO\List\Output(
            items: $repo->items(),
            total: $repo->total(),
            last_page: $repo->lastPage(),
            first_page: $repo->firstPage(),
            current_page: $repo->currentPage(),
            per_page: $repo->perPage(),
            to: $repo->to(),
            from: $repo->from()
        );
    }
}
