<?php

namespace Tests\Unit\CastMember\UseCases;

use Costa\Core\Modules\CastMember\Entities\CastMember as Entity;
use Costa\Core\Modules\CastMember\Entities\CastMember;
use Costa\Core\Modules\CastMember\Enums\CastMemberType;
use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\CastMember\UseCases\DTO\Updated\Input;
use Costa\Core\Modules\CastMember\UseCases\DTO\Updated\Output;
use Costa\Core\Modules\CastMember\UseCases\UpdateCastMemberUseCase as UseCase;
use Costa\Core\Utils\ValueObject\Uuid;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateCastMemberUserCaseUnitTest extends TestCase
{
    public function testRename(){
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            CastMemberType::ACTOR,
            $id,
        ]);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('updatedAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('update')->shouldReceive('enable');
        $mockEntity->shouldReceive('changeType')->shouldReceive('enable')->andReturn(1);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->once()->andReturn($mockEntity);
        $mockRepo->shouldReceive('update')->once()->andReturn($mockEntity);

        $mockInput = Mockery::mock(Input::class, [
            $id,
            'tesadwada',
            1
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('findById')->andReturn($mockEntity);
        $mockSpy->shouldReceive('update')->andReturn($mockEntity);

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('findById');
        $mockSpy->shouldHaveReceived('update');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
