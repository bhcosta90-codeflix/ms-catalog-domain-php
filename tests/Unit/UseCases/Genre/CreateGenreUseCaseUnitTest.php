<?php

namespace Tests\Unit\UseCase\Genre;

use Costa\Core\Domains\Entities\Genre as Entity;
use Costa\Core\Domains\Exceptions\NotFoundDomainException;
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
    public function testCreateNewGenre()
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
        $mockSpy->shouldReceive('insert')->andReturn($this->mockEntity());

        $useCase = new UseCase($mockSpy, $mockTransaction, $mockCategoryRepository);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('insert');
    }

    public function testCreateNewGenreCategoryNotFound()
    {
        $this->expectException(NotFoundDomainException::class);

        $idCategory = Uuid::random();

        $mockRepo = $this->mockRepository(0);
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
        return $mockEntity;
    }

    private function mockRepository($times = 1)
    {
        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('insert')
            ->times($times)
            ->andReturn($this->mockEntity());

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
            $categoryName,
            true,
            '',
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
