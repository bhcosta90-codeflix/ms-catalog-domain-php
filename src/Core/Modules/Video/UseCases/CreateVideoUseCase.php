<?php

namespace Costa\Core\Modules\Video\UseCases;

use Costa\Core\Modules\Video\Contracts\VideoEventManagerInterface;
use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Modules\Video\Repositories\VideoRepositoryInterface;
use Costa\Core\Utils\Contracts\{FileStorageInterface, TransactionInterface};

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
        $obj = new Video(
            title: $input->title,
            description: $input->description,
            yearLaunched: $input->yearLaunched,
            duration: $input->duration,
            opened: $input->opened,
            rating: $input->rating,
        );

        // add categories_id in entity - validate
        // add genres_id in entity - validate
        // add cast_members_id in entity - validate

        // repository persist in database
        // storage of media, using the entity id persist
        // dispatch event
        // transaction

        return new DTO\Created\Output(
            id: $obj->id(),
            title: $obj->title,
            description: $obj->description,
            yearLaunched: $obj->yearLaunched,
            duration: $obj->duration,
            opened: $obj->opened,
            rating: $obj->rating,
        );
    }
}
