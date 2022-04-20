<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category as Entity;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\UseCases\Category\DTO\Updated\Input;
use Costa\Core\UseCases\Category\DTO\Updated\Output;
use Costa\Core\UseCases\Category\UpdateCategoryUseCase as UseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateCategoryUserCaseUnitTest extends TestCase
{
    public function testRename(){
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $id,
            $categoryName
        ]);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('update')->shouldReceive('enable');

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->once()->andReturn($mockEntity);
        $mockRepo->shouldReceive('update')->once()->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $id,
            'tesadwada'
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('findById')->andReturn($mockEntity);
        $mockSpy->shouldReceive('update')->andReturn($mockEntity);

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('findById');
        $mockSpy->shouldHaveReceived('update');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
