<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\UseCases\Category\CreateCategoryUseCase;
use Costa\Core\UseCases\Category\DTO\Category\CategoryInput;
use Costa\Core\UseCases\Category\DTO\Category\CategoryOutput;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

final class CreateCategoryUseCaseUnitTest extends TestCase
{
    private Category $mockEntity;
    private CategoryInput $mockInput;
    private CategoryRepositoryInterface $mockRepo;

    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(CategoryInput::class, [
            $categoryName
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $responseUserCase = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(CategoryOutput::class, $responseUserCase);
        $this->assertEquals($categoryName, $responseUserCase->name);
        $this->assertEquals('', $responseUserCase->description);

        /**
         * Spies
         */
        $this->spyRepo = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spyRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateCategoryUseCase($this->spyRepo);
        $responseUserCase = $useCase->execute($this->mockInput);
        $this->spyRepo->shouldHaveReceived('insert');

        Mockery::close();
    }
}
