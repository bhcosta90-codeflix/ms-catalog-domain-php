<?php

namespace Tests\Unit\CastMember\UseCase;

use Costa\Core\Modules\CastMember\Entities\CastMember as Entity;
use Costa\Core\Modules\CastMember\Enums\CastMemberType;
use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface as RepositoryInterface;
use Costa\Core\Utils\ValueObject\Uuid;
use Costa\Core\Modules\CastMember\UseCases\CreateCastMemberUseCase as UseCase;
use Costa\Core\Modules\CastMember\UseCases\DTO\Created\Input;
use Costa\Core\Modules\CastMember\UseCases\DTO\Created\Output;
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
