<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\PaginationInterface;
use Costa\Core\UseCases\Category\DTO\List\Input;
use Costa\Core\UseCases\Category\DTO\List\Output;
use Costa\Core\UseCases\Category\ListCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ListCategoryUserCaseUnitTest extends TestCase
{
    public function testListCategoryUseCaseEmpty()
    {
        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($this->mockPagination());

        $useCase = new ListCategoryUseCase($this->mockRepo);

        $this->mockInput = Mockery::mock(Input::class, [
            []
        ]);

        $response = $useCase->execute($this->mockInput);
        $this->assertCount(0, $response->items);
        $this->assertInstanceOf(Output::class, $response);

        /**
         * spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')->andReturn($this->mockPagination());

        $useCase = new ListCategoryUseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('paginate');
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
        
        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($this->mockPagination([$register]));

        $useCase = new ListCategoryUseCase($this->mockRepo);

        $this->mockInput = Mockery::mock(Input::class, [
            []
        ]);

        $response = $useCase->execute($this->mockInput);
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
