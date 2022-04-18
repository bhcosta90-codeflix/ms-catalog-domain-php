<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\PaginationInterface;
use Costa\Core\UseCases\Category\DTO\Category\CategoryList;
use Costa\Core\UseCases\Category\DTO\Category\CategoryListOutput;
use Costa\Core\UseCases\Category\ListCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

final class ListCategoryUserCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($this->mockPagination());

        $useCase = new ListCategoryUseCase($this->mockRepo);

        $this->mockInput = Mockery::mock(CategoryList::class, [
            []
        ]);

        $response = $useCase->execute($this->mockInput);
        $this->assertCount(0, $response->items);
        $this->assertInstanceOf(CategoryListOutput::class, $response);
    }

    private function mockPagination(){
        $mock = Mockery::mock(stdClass::class, PaginationInterface::class);
        $mock->shouldReceive('items')->andReturn([]);
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
