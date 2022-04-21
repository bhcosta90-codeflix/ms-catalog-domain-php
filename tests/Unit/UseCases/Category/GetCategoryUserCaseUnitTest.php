<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Category\Entities\Category as Entity;
use Costa\Core\Category\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\Category\UseCases\GetCategoryUseCase as UseCase;
use Costa\Core\Category\UseCases\DTO\Find\Input;
use Costa\Core\Category\UseCases\DTO\Find\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class GetCategoryUserCaseUnitTest extends TestCase
{
   
    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);
        $mockEntity->shouldReceive('id')->andReturn($id);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->with($id)->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('findById')->with($id)->andReturn($mockEntity);

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('findById');

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
