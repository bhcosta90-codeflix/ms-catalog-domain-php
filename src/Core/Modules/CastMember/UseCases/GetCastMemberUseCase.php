<?php

namespace Costa\Core\Modules\CastMember\UseCases;

use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface;

final class GetCastMemberUseCase
{
    public function __construct(
        private CastMemberRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Find\Input $input): DTO\Find\Output
    {
        $repo = $this->repository->findById($input->id);

        return new DTO\Find\Output(
            id: $repo->id,
            name: $repo->name,
            type: $repo->type->value,
            is_active: $repo->isActive,
            created_at: $repo->createdAt(),
            updated_at: $repo->updatedAt(),
        );
    }
}
