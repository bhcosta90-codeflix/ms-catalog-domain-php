<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category as Entity;
use Costa\Core\Domains\Repositories\CategoryRepositoryInterface as RepositoryInterface;
use Costa\Core\UseCases\Category\CreateCategoryUseCase as UseCase;
use Costa\Core\UseCases\Category\DTO\Created\Input;
use Costa\Core\UseCases\Category\DTO\Created\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

final class CreateCategoryUseCaseUnitTest extends TestCase
{
    private Entity $mockEntity;
    private Input $mockInput;
    private RepositoryInterface $mockRepo;

    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Entity::class, [
            $uuid,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInput = Mockery::mock(Input::class, [
            $categoryName
        ]);

        $useCase = new UseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals('', $response->description);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new UseCase($this->spy);
        $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
