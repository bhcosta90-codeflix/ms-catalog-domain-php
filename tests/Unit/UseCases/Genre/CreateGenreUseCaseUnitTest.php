<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\UseCases\Contracts\TransactionContract;
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

        $mockEntity = Mockery::mock(Genre::class, [
            $categoryName,
            $uuid,
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepo->shouldReceive('insert')->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $categoryName
        ]);

        $mockTransaction = Mockery::mock(stdClass::class, TransactionContract::class);
        $mockCategory = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);

        $useCase = new CreateGenreUseCase($mockRepo, $mockTransaction, $mockCategory);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, GenreRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($mockEntity);

        $useCase = new CreateGenreUseCase($this->spy, $mockTransaction, $mockCategory);
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

    //     $mockRepo = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
    //     $mockRepo->shouldReceive('insert')->andReturn($mockEntity);

    //     $mockInput = Mockery::mock(Input::class, [
    //         $categoryName
    //     ]);

    //     $useCase = new CreateGenreUseCase($mockRepo);
    //     $response = $useCase->execute($mockInput);

    //     $this->assertInstanceOf(Output::class, $response);
    //     $this->assertEquals($categoryName, $response->name);

    //     /**
    //      * Spies
    //      */
    //     $this->spy = Mockery::spy(stdClass::class, GenreRepositoryInterface::class);
    //     $this->spy->shouldReceive('insert')->andReturn($mockEntity);

    //     $useCase = new CreateGenreUseCase($this->spy);
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
