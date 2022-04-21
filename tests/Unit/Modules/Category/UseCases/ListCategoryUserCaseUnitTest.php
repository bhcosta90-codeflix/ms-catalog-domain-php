<?php

namespace Tests\Unit\Category\UseCases;

use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\Category\UseCases\ListCategoryUseCase as UseCase;
use Costa\Core\Utils\Contracts\PaginationInterface;
use Costa\Core\Modules\Category\UseCases\DTO\List\Input;
use Costa\Core\Modules\Category\UseCases\DTO\List\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoryUserCaseUnitTest extends TestCase
{
    public function testListCategoryUseCaseEmpty()
    {
        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($this->mockPagination());

        $useCase = new UseCase($mockRepo);

        $mockInput = Mockery::mock(Input::class, [
            []
        ]);

        $response = $useCase->execute($mockInput);
        $this->assertCount(0, $response->items);
        $this->assertInstanceOf(Output::class, $response);

        /**
         * spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('paginate')->andReturn($this->mockPagination());

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('paginate');
    }

    public function testListCategoryUseCase()
    {
        $register = new stdClass();
        $register->id = '16156';
        $register->name = 'dopkaodpkpak';
        $register->description = 'description';
        $register->is_active = true;
        $register->created_at = 'created_at';
        $register->updated_id = 'updated_id';
        
        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($this->mockPagination([$register]));

        $useCase = new UseCase($mockRepo);

        $mockInput = Mockery::mock(Input::class, [
            []
        ]);

        $response = $useCase->execute($mockInput);
        $this->assertCount(1, $response->items);
        $this->assertInstanceOf(Output::class, $response);
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
