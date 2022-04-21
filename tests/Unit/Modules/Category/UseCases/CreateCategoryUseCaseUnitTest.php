<?php

namespace Tests\Unit\Category\UseCases;

use Costa\Core\Modules\Category\Entities\Category as Entity;
use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\Category\UseCases\CreateCategoryUseCase as UseCase;
use Costa\Core\Modules\Category\UseCases\DTO\Created\Input;
use Costa\Core\Modules\Category\UseCases\DTO\Created\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{

    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $uuid,
            $categoryName
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('insert')->once()->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $categoryName
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals('', $response->description);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('insert')->andReturn($mockEntity);

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('insert');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
