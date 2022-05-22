<?php

namespace Tests\Unit\Modules\Video\UseCases;

use Costa\Core\Modules\Video\Contracts\{VideoEventManagerInterface};
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
        $uc = new UseCase(
            repository: $this->getMockRepository(),
            transaction: $this->getMockTransaction(),
            storage: $this->getMockFileStorage(),
            event: $this->getMockVideoEventManagerInterface(),
        );
        
        $ret = $uc->exec(
            input: $this->getMockInput(),
        );

        $this->assertInstanceOf(CreatedOutput::class, $ret);
    }

    protected function getMockRepository(): VideoRepositoryInterface
    {
        return Mockery::mock(stdClass::class, VideoRepositoryInterface::class);
    }

    protected function getMockTransaction(): TransactionInterface
    {
        return Mockery::mock(stdClass::class, TransactionInterface::class);
    }

    protected function getMockFileStorage(): FileStorageInterface
    {
        return Mockery::mock(stdClass::class, FileStorageInterface::class);
    }

    protected function getMockVideoEventManagerInterface(): VideoEventManagerInterface
    {
        return Mockery::mock(stdClass::class, VideoEventManagerInterface::class);
    }

    protected function getMockInput(): CreatedInput
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
