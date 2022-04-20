<?php

namespace Tests\Unit\UseCase\CastMember;

use Costa\Core\Domains\Entities\CastMember as Entity;
use Costa\Core\Domains\Enums\CastMemberType;
use Costa\Core\Domains\Repositories\CastMemberRepositoryInterface as RepositoryInterface;
use Costa\Core\Domains\ValueObject\Uuid;
use Costa\Core\UseCases\CastMember\CreateCastMemberUseCase as UseCase;
use Costa\Core\UseCases\CastMember\DTO\Created\Input;
use Costa\Core\UseCases\CastMember\DTO\Created\Output;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateCastMemberUseCaseUnitTest extends TestCase
{

    public function testCreateNewCastMember()
    {
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            CastMemberType::ACTOR,
            Uuid::random(),
        ]);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('insert')->once()->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $categoryName,
            CastMemberType::ACTOR,
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals(CastMemberType::ACTOR, $response->type);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
