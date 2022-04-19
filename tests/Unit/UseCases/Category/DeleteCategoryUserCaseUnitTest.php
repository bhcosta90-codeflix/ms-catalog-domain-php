<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category as Entity;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\UseCases\Category\DeleteCategoryUseCase as UseCase;
use Costa\Core\UseCases\Category\DTO\Deleted\Input;
use Costa\Core\UseCases\Category\DTO\Deleted\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCategoryUserCaseUnitTest extends TestCase
{
    public function testDelete(){
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('delete');

        $this->mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('delete')->andReturn(true);

        $this->mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertTrue($response->success);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('delete')->andReturn(true);

        $useCase = new UseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('delete');
    }

    public function testDeleteFalse(){
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('delete');

        $this->mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('delete')->andReturn(false);

        $this->mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertFalse($response->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
