<?php

namespace Costa\Core\UseCases\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\UseCases\Category\DTO\Category\CategoryOutput;

final class ListCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Category\ListCategory\Input $obj): DTO\Category\ListCategory\Output
    {
        $repo = $this->repository->paginate(
            filters: $obj->filter,
            page: $obj->page,
            totalPage: $obj->totalPage,
        );


        // return new DTO\Category\ListCategory\Output(
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

        return new DTO\Category\ListCategory\Output(
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
