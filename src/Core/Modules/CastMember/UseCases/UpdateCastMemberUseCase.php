<?php

namespace Costa\Core\Modules\CastMember\UseCases;

use Costa\Core\Modules\CastMember\Enums\CastMemberType;
use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface;

final class UpdateCastMemberUseCase
{
    public function __construct(
        private CastMemberRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Updated\Input $input): DTO\Updated\Output
    {
        $repo = $this->repository->findById($input->id);

        $input->isActive !== null ? ($input->isActive ? $repo->enable() : $repo->disable()) : null;
        $repo->changeType($input->type == 1 ? CastMemberType::DIRECTOR : CastMemberType::ACTOR);

        $repo->update(
            name: $input->name
        );

        $categoryUpdated = $this->repository->update($repo);

        return new DTO\Updated\Output(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            type: $input->type,
            is_active: $categoryUpdated->isActive,
            created_at: $categoryUpdated->createdAt(),
            updated_at: $categoryUpdated->updatedAt(),
        );
    }
}
