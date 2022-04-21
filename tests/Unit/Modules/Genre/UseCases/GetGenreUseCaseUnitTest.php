<?php

namespace Tests\Unit\Genre\UseCases;

use Costa\Core\Modules\Genre\Entities\Genre as Entity;
use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\Genre\UseCases\GetGenreUseCase as UseCase;
use Costa\Core\Utils\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Genre\UseCases\DTO\Find\Input;
use Costa\Core\Modules\Genre\UseCases\DTO\Find\Output;
use Mockery;
use stdClass;

class GetGenreUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            $id,
        ]);
        $mockEntity->shouldReceive('id')->andReturn($id);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->with((string) $id)->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            (string) $id
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
        $mockSpy->shouldReceive('findById')->with((string) $id)->andReturn($mockEntity);

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
