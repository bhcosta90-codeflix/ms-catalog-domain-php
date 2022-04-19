<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre as Entity;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface as RepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\UseCases\Contracts\TransactionContract;
use Costa\Core\UseCases\Genre\CreateGenreUseCase as UseCase;
use Costa\Core\UseCases\Genre\DTO\Created\Input;
use Costa\Core\UseCases\Genre\DTO\Created\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateGenreUseCaseUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $uuid = Uuid::random();
        $idCategory = Uuid::random();

        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            $uuid,
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('insert')->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $categoryName,
            true,
            '',
            [$idCategory]
        ]);

        $mockTransaction = Mockery::mock(stdClass::class, TransactionContract::class);
        $mockCategoryRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);

        $useCase = new UseCase($mockRepo, $mockTransaction, $mockCategoryRepository);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('insert')->andReturn($mockEntity);

        $useCase = new UseCase($mockSpy, $mockTransaction, $mockCategoryRepository);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('insert');

        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
