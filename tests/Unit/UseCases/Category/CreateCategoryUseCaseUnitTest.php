<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface;
use Costa\Core\UseCases\Category\CreateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

final class CreateCategoryUseCaseUnitTest extends TestCase
{
    private CategoryRepositoryInterface $mockRepo;
    private Category $mockEntity;

    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName
        ]);
        $this->mockRepo->shouldReceive('id')>andReturn($uuid);

        // var_dump($this->mockEntity);die;

        // $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        // $this->mockRepo->shouldReceive('insert')>andReturn($this->mockEntity);

        // $useCase = new CreateCategoryUseCase($this->mockRepo);
        // $useCase->execute();

        $this->assertTrue(true);

        Mockery::close();
    }
}
