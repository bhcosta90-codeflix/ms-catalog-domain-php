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

final class CreateGenreUseCaseUnitTest extends TestCase
{
    private Entity $mockEntity;
    private Input $mockInput;
    private RepositoryInterface $mockRepo;

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
        $this->spy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($mockEntity);

        $useCase = new UseCase($this->spy, $mockTransaction, $mockCategoryRepository);
        $useCase->execute($mockInput);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }

    // public function testCreateNewCategory()
    // {
    //     $uuid = Uuid::random();
    //     $categoryName = 'teste de categoria';

    //     $mockEntity = Mockery::mock(Genre::class, [
    //         $categoryName,
    //         $uuid,
    //     ]);
    //     $mockEntity->shouldReceive('id')->andReturn($uuid);
    //     $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

    //     $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
    //     $mockRepo->shouldReceive('insert')->andReturn($mockEntity);

    //     $mockInput = Mockery::mock(Input::class, [
    //         $categoryName
    //     ]);

    //     $useCase = new UseCase($mockRepo);
    //     $response = $useCase->execute($mockInput);

    //     $this->assertInstanceOf(Output::class, $response);
    //     $this->assertEquals($categoryName, $response->name);

    //     /**
    //      * Spies
    //      */
    //     $this->spy = Mockery::spy(stdClass::class, RepositoryInterface::class);
    //     $this->spy->shouldReceive('insert')->andReturn($mockEntity);

    //     $useCase = new UseCase($this->spy);
    //     $useCase->execute($mockInput);
    //     $this->spy->shouldHaveReceived('insert');

    //     Mockery::close();
    // }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
