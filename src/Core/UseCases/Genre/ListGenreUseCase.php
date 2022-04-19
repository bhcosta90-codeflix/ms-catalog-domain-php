<?php

namespace Costa\Core\UseCases\Genre;

use Costa\Core\Domains\Repositories\GenreRepositoryInterface;

class ListGenreUseCase
{
    public function __construct(
        private GenreRepositoryInterface $repository
    ) {
        //
    }

    public function execute()
    {
        
    }
}
