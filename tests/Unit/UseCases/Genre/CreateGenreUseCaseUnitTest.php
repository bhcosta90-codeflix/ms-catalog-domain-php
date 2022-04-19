<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\UseCases\Genre\CreateGenreUseCase;
use Costa\Core\UseCases\Genre\DTO\Created\Input;
use Costa\Core\UseCases\Genre\DTO\Created\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

final class CreateGenreUseCaseUnitTest extends TestCase
{
    private Genre $mockEntity;
    private Input $mockInput;
    private GenreRepositoryInterface $mockRepo;

    public function testCreateNewCategory()
    {
        $uuid = Uuid::random();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Genre::class, [
            $categoryName,
            $uuid,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(Input::class, [
            $categoryName
        ]);

        $useCase = new CreateGenreUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, GenreRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateGenreUseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
