<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\UseCases\Genre\DTO\Updated\Input;
use Costa\Core\UseCases\Genre\DTO\Updated\Output;
use Costa\Core\UseCases\Genre\UpdateGenreUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;

final class UpdateGenreUserCaseUnitTest extends TestCase
{
    public function testRename(){
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Genre::class, [
            $categoryName,
            $id,
        ]);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('update')->shouldReceive('enable');

        $this->mockRepo = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(Input::class, [
            $id,
            'tesadwada'
        ]);

        $useCase = new UpdateGenreUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, GenreRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);

        $useCase = new UpdateGenreUseCase($this->spy);
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
