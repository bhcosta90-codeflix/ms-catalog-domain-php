<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category as Entity;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\UseCases\Category\GetCategoryUseCase as UseCase;
use Costa\Core\UseCases\Category\DTO\Find\Input;
use Costa\Core\UseCases\Category\DTO\Find\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class GetCategoryUserCaseUnitTest extends TestCase
{
    private Entity $mockEntity;
    
    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);

        $useCase = new UseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('findById');

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
