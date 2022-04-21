<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Category\Entities\Category as Entity;
use Costa\Core\Category\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\Category\UseCases\DeleteCategoryUseCase as UseCase;
use Costa\Core\Category\UseCases\DTO\Deleted\Input;
use Costa\Core\Category\UseCases\DTO\Deleted\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCategoryUserCaseUnitTest extends TestCase
{
    public function testDelete(){
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);
        $mockRepo->shouldReceive('delete')->andReturn(true);

        $mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertTrue($response->success);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('findById')->andReturn($mockEntity);
        $mockSpy->shouldReceive('delete')->andReturn(true);

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('findById');
        $mockSpy->shouldHaveReceived('delete');
    }

    public function testDeleteFalse(){
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->once()->andReturn($mockEntity);
        $mockRepo->shouldReceive('delete')->once()->andReturn(false);

        $mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertFalse($response->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
