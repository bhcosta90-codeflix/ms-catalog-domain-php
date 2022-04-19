<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Costa\Core\UseCases\Genre\ListGenreUseCase;
use Mockery;
use stdClass;

final class ListGenreUserCaseUnitTest extends TestCase
{
    public function testUseCase()
    {
        $mockery = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);

        $useCase = new ListGenreUseCase($mockery);
        $useCase->execute();

        Mockery::close();
    }
}
