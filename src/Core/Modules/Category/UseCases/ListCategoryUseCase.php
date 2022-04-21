<?php

namespace Costa\Core\Modules\Category\UseCases;

use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface;

class ListCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
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


        // return new DTO\List\Output(
        //     items: array_map(function($data){
        //         return [
        //             'id' => $data->id,
        //             'name' => $data->name,
        //             'description' => $data->description,
        //             'is_active' => $data->is_active,
        //             'is_active' => $data->is_active,
        //             'created_at' => (string) $data->created_at,
        //         ];
        //     }, $repo->items()),
        //     total: $repo->total(),
        //     last_page: $repo->lastPage(),
        //     first_page: $repo->firstPage(),
        //     current_page: $repo->currentPage(),
        //     per_page: $repo->perPage(),
        //     to: $repo->to(),
        //     from: $repo->from()
        // );

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
