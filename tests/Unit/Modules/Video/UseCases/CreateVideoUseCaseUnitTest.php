<?php

namespace Tests\Unit\Modules\Video\UseCases;

use Costa\Core\Modules\Video\Contracts\{VideoEventManagerInterface};
use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Modules\Video\Repositories\VideoRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Video\UseCases\CreateVideoUseCase as UseCase;
use Costa\Core\Utils\Contracts\{FileStorageInterface, TransactionInterface};
use Costa\Core\Modules\Video\UseCases\DTO\Created\Input as CreatedInput;
use Costa\Core\Modules\Video\UseCases\DTO\Created\Output as CreatedOutput;
use Mockery;
use stdClass;

class CreateVideoUseCaseUnitTest extends TestCase
{
    public function test_constructor()
    {
        new UseCase(
            repository: $this->getMockRepository(),
            transaction: $this->getMockTransaction(),
            storage: $this->getMockFileStorage(),
            event: $this->getMockVideoEventManagerInterface(),
        );

        $this->assertTrue(true);
    }

    public function testExecInputOutput(){
        $transaction = $this->getMockTransaction();
        $transaction->shouldReceive('commit');
        $transaction->shouldReceive('rollback');

        $repository = $this->getMockRepository();
        $repository->shouldReceive('insert')->andReturn($this->getMockEntity());

        $uc = new UseCase(
            repository: $repository,
            transaction: $transaction,
            storage: $this->getMockFileStorage(),
            event: $this->getMockVideoEventManagerInterface(),
        );
        
        $ret = $uc->exec(
            input: $this->getMockInput(),
        );

        $this->assertInstanceOf(CreatedOutput::class, $ret);
    }

    protected function getMockEntity(): Video|Mockery\MockInterface
    {
        return Mockery::mock(stdClass::class, Video::class);
    }

    protected function getMockRepository(): VideoRepositoryInterface|Mockery\MockInterface
    {
        return Mockery::mock(stdClass::class, VideoRepositoryInterface::class);
    }

    protected function getMockTransaction(): TransactionInterface|Mockery\MockInterface
    {
        return Mockery::mock(stdClass::class, TransactionInterface::class);
    }

    protected function getMockFileStorage(): FileStorageInterface|Mockery\MockInterface
    {
        return Mockery::mock(stdClass::class, FileStorageInterface::class);
    }

    protected function getMockVideoEventManagerInterface(): VideoEventManagerInterface|Mockery\MockInterface
    {
        return Mockery::mock(stdClass::class, VideoEventManagerInterface::class);
    }

    protected function getMockInput(): CreatedInput|Mockery\MockInterface
    {
        return Mockery::mock(CreatedInput::class, [
            'teste',
            'teste',
            2000,
            500,
            Rating::RATE10
        ]);
    }
}
