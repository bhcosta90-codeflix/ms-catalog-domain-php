<?php

namespace Costa\Core\Modules\CastMember\UseCases;

use Costa\Core\Modules\CastMember\Entities\CastMember;
use Costa\Core\Modules\CastMember\Enums\CastMemberType;
use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface;

final class CreateCastMemberUseCase
{
    public function __construct(
        private CastMemberRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Created\Input $input): DTO\Created\Output
    {
        $obj = new CastMember(
            name: $input->name,
            type: $input->type == 1 ? CastMemberType::DIRECTOR : CastMemberType::ACTOR,
            isActive: $input->isActive,
        );

        $this->repository->insert($obj);

        return new DTO\Created\Output(
            id: $obj->id,
            name: $obj->name,
            type: $obj->type->value,
            is_active: $obj->isActive,
            created_at: $obj->createdAt(),
            updated_at: $obj->createdAt(),
        );
    }
}
