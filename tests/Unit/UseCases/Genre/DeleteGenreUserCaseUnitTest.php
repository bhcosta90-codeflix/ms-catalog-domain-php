<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\Modules\Genre\Entities\Genre as Entity;
use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\Genre\UseCases\DeleteGenreUseCase as UseCase;
use Costa\Core\Modules\Genre\UseCases\DTO\Deleted\Input;
use Costa\Core\Modules\Genre\UseCases\DTO\Deleted\Output;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeleteGenreUserCaseUnitTest extends TestCase
{
    public function testDelete(){
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            $id,
        ]);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->once()->andReturn($mockEntity);
        $mockRepo->shouldReceive('delete')->once()->andReturn(true);

        $mockInput = Mockery::mock(Input::class, [
            (string) $id
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
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            $id,
        ]);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);
        $mockRepo->shouldReceive('delete')->andReturn(false);

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
