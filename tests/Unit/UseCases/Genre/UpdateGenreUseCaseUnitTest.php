<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre as Entity;
use Costa\Core\Domains\Exceptions\NotFoundDomainException;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\Domains\Repositories\GenreRepositoryInterface as RepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\UseCases\Contracts\TransactionContract;
use Costa\Core\UseCases\Genre\UpdateGenreUseCase as UseCase;
use Costa\Core\UseCases\Genre\DTO\Updated\Input;
use Costa\Core\UseCases\Genre\DTO\Updated\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class UpdateGenreUseCaseUnitTest extends TestCase
{
    public function testUpdateGenre()
    {
        $idCategory = Uuid::random();

        $mockRepo = $this->mockRepository();
        $mockInput = $this->mockInput([$idCategory]);
        $mockTransaction = $this->mockTransaction();
        $mockCategoryRepository = $this->mockCategory([$idCategory]);

        $useCase = new UseCase($mockRepo, $mockTransaction, $mockCategoryRepository);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals("teste de categoria", $response->name);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('findById')->andReturn($entity = $this->mockEntity());
        $mockSpy->shouldReceive('update')->andReturn($entity);

        $useCase = new UseCase($mockSpy, $mockTransaction, $mockCategoryRepository);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('update');
    }

    public function testUpdateGenreCategoryNotFound()
    {
        $this->expectException(NotFoundDomainException::class);

        $idCategory = Uuid::random();

        $mockRepo = $this->mockRepository();
        $mockTransaction = $this->mockTransaction();
        $mockCategoryRepository = $this->mockCategory([$idCategory]);

        $useCase = new UseCase($mockRepo, $mockTransaction, $mockCategoryRepository);
        $useCase->execute($this->mockInput([$idCategory, 'fake-value']));
    }

    private function mockEntity()
    {
        $uuid = Uuid::random();
        $categoryName = 'teste de categoria';
        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            $uuid,
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('addCategory');
        $mockEntity->shouldReceive('enable');
        $mockEntity->shouldReceive('update');
        return $mockEntity;
    }

    private function mockRepository()
    {
        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($entity = $this->mockEntity());
        $mockRepo->shouldReceive('update')->andReturn($entity);

        return $mockRepo;
    }

    private function mockTransaction(){
        $mockTransaction = Mockery::mock(stdClass::class, TransactionContract::class);
        $mockTransaction->shouldReceive('commit');
        $mockTransaction->shouldReceive('rollback');

        return $mockTransaction;
    }

    private function mockCategory(array $idCategory = [])
    {
        $mockCategoryRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockCategoryRepository->shouldReceive('getIds')->andReturn($idCategory);

        return $mockCategoryRepository;
    }

    private function mockInput(array $idCategory = []){
        $categoryName = 'teste de categoria';

        $mockInput = Mockery::mock(Input::class, [
            Uuid::random(),
            $categoryName,
            true,
            $idCategory
        ]);

        return $mockInput;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}