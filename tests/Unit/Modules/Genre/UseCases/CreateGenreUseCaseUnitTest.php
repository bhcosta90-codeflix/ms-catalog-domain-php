<?php

namespace Tests\Unit\Modules\Genre\UseCases;

use Costa\Core\Modules\Genre\Entities\Genre as Entity;
use Costa\Core\Utils\Exceptions\NotFoundDomainException;
use Costa\Core\Modules\Category\Repositories\CategoryRepositoryInterface;
use Costa\Core\Modules\Genre\Repositories\GenreRepositoryInterface as RepositoryInterface;
use Costa\Core\Utils\ValueObject\Uuid;
use Costa\Core\Utils\Contracts\TransactionInterface;
use Costa\Core\Modules\Genre\UseCases\CreateGenreUseCase as UseCase;
use Costa\Core\Modules\Genre\UseCases\DTO\Created\Input;
use Costa\Core\Modules\Genre\UseCases\DTO\Created\Output;
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
        $mockTransaction = Mockery::mock(stdClass::class, TransactionInterface::class);
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
