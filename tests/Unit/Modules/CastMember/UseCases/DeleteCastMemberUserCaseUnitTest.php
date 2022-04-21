<?php

namespace Tests\Unit\CastMember\UseCases;

use Costa\Core\Modules\CastMember\Entities\CastMember as Entity;
use Costa\Core\Modules\CastMember\Enums\CastMemberType;
use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface as RepositoryInterface;
use Costa\Core\Modules\CastMember\UseCases\DeleteCastMemberUseCase as UseCase;
use Costa\Core\Modules\CastMember\UseCases\DTO\Deleted\Input;
use Costa\Core\Modules\CastMember\UseCases\DTO\Deleted\Output;
use Costa\Core\Utils\ValueObject\Uuid;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeleteCastMemberUserCaseUnitTest extends TestCase
{
    public function testDelete(){
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            CastMemberType::ACTOR,
            $id,
        ]);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);
        $mockRepo->shouldReceive('delete')->andReturn(true);

        $mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertTrue($response->success);

        /**
         * Spies
         */
        $mockSpy = Mockery::spy(stdClass::class, RepositoryInterface::class);
        $mockSpy->shouldReceive('findById')->andReturn($mockEntity);
        $mockSpy->shouldReceive('delete')->andReturn(true);

        $useCase = new UseCase($mockSpy);
        $useCase->execute($mockInput);
        $mockSpy->shouldHaveReceived('findById');
        $mockSpy->shouldHaveReceived('delete');
    }

    public function testDeleteFalse(){
        $id = Uuid::random();
        $categoryName = 'teste de categoria';

        $mockEntity = Mockery::mock(Entity::class, [
            $categoryName,
            CastMemberType::ACTOR,
            $id,
        ]);

        $mockRepo = Mockery::mock(stdClass::class, RepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->once()->andReturn($mockEntity);
        $mockRepo->shouldReceive('delete')->once()->andReturn(false);

        $mockInput = Mockery::mock(Input::class, [
            $id
        ]);

        $useCase = new UseCase($mockRepo);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(Output::class, $response);
        $this->assertFalse($response->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
