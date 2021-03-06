<?php

namespace Tests\Unit\Modules\Genre\UseCases;

use Costa\Core\Modules\Genre\UseCases\ListGenreUseCase as UseCase;
use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface as RepositoryInterface;

use Costa\Core\Utils\Contracts\PaginationInterface;
use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Genre\UseCases\DTO\List\Input;
use Costa\Core\Modules\Genre\UseCases\DTO\List\Output;
use Mockery;
use stdClass;

class ListGenreUserCaseUnitTest extends TestCase
{
    public function testUseCaseEmpty()
    {
        $mockRepository = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepository->shouldReceive('paginate')->andReturn($this->mockPagination());

        $mockInput = Mockery::mock(Input::class, []);

        $useCase = new UseCase($mockRepository);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertCount(0, $response->items);

        /**
         * spies
         */
        $spy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $spy->shouldReceive('paginate')->andReturn($this->mockPagination());

        $useCase = new UseCase($spy);
        $useCase->execute($mockInput);
        $spy->shouldHaveReceived('paginate');
    }

    public function testUseCase()
    {
        $register = new stdClass();
        $register->id = '16156';
        $register->name = 'dopkaodpkpak';

        $mockRepository = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepository->shouldReceive('paginate')->andReturn($this->mockPagination([$register]));

        $mockInput = Mockery::mock(Input::class, []);

        $useCase = new UseCase($mockRepository);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertCount(1, $response->items);
    }

    private function mockPagination($items = []){
        $mock = Mockery::mock(stdClass::class, PaginationInterface::class);
        $mock->shouldReceive('items')->andReturn($items);
        $mock->shouldReceive('total')->andReturn(0);
        $mock->shouldReceive('lastPage')->andReturn(0);
        $mock->shouldReceive('firstPage')->andReturn(0);
        $mock->shouldReceive('currentPage')->andReturn(0);
        $mock->shouldReceive('perPage')->andReturn(0);
        $mock->shouldReceive('to')->andReturn(0);
        $mock->shouldReceive('from')->andReturn(0);

        return $mock;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
