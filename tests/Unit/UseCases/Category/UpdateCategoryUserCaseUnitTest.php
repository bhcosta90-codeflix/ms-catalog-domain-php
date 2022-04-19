<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\UseCases\Category\DTO\Category\UpdatedCategory\Input;
use Costa\Core\UseCases\Category\DTO\Category\UpdatedCategory\Output;
use Costa\Core\UseCases\Category\UpdateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UpdateCategoryUserCaseUnitTest extends TestCase
{
    public function testRename(){
        $id = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('update');

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(Input::class, [
            $id,
            'tesadwada'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);

        $useCase = new UpdateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
