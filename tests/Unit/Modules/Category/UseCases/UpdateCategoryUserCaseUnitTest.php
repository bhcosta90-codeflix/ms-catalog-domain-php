<?php

namespace Tests\Unit\Modules\Category\UseCases;

use Costa\Core\Modules\Category\Entities\Category as Entity;
use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\Category\UseCases\DTO\Updated\Input;
use Costa\Core\Modules\Category\UseCases\DTO\Updated\Output;
use Costa\Core\Modules\Category\UseCases\UpdateCategoryUseCase as UseCase;
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
