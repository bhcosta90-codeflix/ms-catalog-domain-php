<?php

namespace Costa\Core\Modules\Video\UseCases;

use Costa\Core\Modules\Video\Contracts\VideoEventManagerInterface;
use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Modules\Video\Events\VideoCreatedEvent;
use Costa\Core\Modules\Video\Repositories\VideoRepositoryInterface;
use Costa\Core\Utils\Contracts\{FileStorageInterface, TransactionInterface};
use Throwable;

class CreateVideoUseCase
{
    public function __construct(
        protected VideoRepositoryInterface $repository,
        protected TransactionInterface $transaction,
        protected FileStorageInterface $storage,
        protected VideoEventManagerInterface $event,
    ) {
        //
    }

    public function exec(DTO\Created\Input $input): DTO\Created\Output
    {
        $entity = $this->createEntity($input);

        try {
            $this->repository->insert($entity);
            if ($this->storeMedia($entity->id(), $input->files)) {
                $this->event->dispatch(new VideoCreatedEvent($entity));
            }
            $this->transaction->commit();
            return new DTO\Created\Output(
                id: $entity->id(),
                title: $entity->title,
                description: $entity->description,
                yearLaunched: $entity->yearLaunched,
                duration: $entity->duration,
                opened: true,
                rating: $entity->rating,
            );
        } catch (Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }

    private function createEntity(DTO\Created\Input $input): Video
    {
        $obj = new Video(
            title: $input->title,
            description: $input->description,
            yearLaunched: $input->yearLaunched,
            duration: $input->duration,
            opened: true,
            rating: $input->rating,
        );

        foreach ($input->categories as $v) {
            $obj->addCategory($v);
        }

        foreach ($input->genres as $v) {
            $obj->addGenre($v);
        }

        foreach ($input->castMembers as $v) {
            $obj->addCastMember($v);
        }

        return $obj;
    }

    private function storeMedia(string $path, array $media): ?string
    {
        if (count($media)) {
            return $this->storage->store($path, $media);
        }

        return null;
    }
}
