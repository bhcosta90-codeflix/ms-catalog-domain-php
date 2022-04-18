<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\UseCases\Category\ListCategoryUseCase;
use Costa\Core\UseCases\Category\DTO\Category\CategoryDto;
use Costa\Core\UseCases\Category\DTO\Category\CategoryOutput;
use Costa\Core\UseCases\Category\GetCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

final class GetCategoryUserCaseUnitTest extends TestCase
{
    private Category $mockEntity;
    
    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(CategoryDto::class, [
            $id
        ]);

        $useCase = new GetCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(CategoryOutput::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);

        $useCase = new GetCategoryUseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('findById');

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
