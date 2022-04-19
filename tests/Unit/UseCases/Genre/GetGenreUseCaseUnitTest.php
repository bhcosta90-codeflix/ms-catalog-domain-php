<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Costa\Core\UseCases\Genre\DTO\FindGenre\Input;
use Costa\Core\UseCases\Genre\DTO\FindGenre\Output;
use Costa\Core\UseCases\Genre\GetGenreUseCase;
use Mockery;
use stdClass;

final class GetGenreUseCaseUnitTest extends TestCase
{
    private Genre $mockEntity;
    
    public function testGetById()
    {
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Genre::class, [
            $categoryName,
            $id,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->with((string) $id)->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(Input::class, [
            (string) $id
        ]);

        $useCase = new GetGenreUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * spies
         */
        $this->spy = Mockery::spy(stdClass::class, GenreRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with((string) $id)->andReturn($this->mockEntity);

        $useCase = new GetGenreUseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('findById');

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
