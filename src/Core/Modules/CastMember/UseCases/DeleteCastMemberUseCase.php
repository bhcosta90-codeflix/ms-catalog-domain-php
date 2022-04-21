<?php

namespace Costa\Core\Modules\CastMember\UseCases;

use Costa\Core\Modules\CastMember\Repositories\CastMemberRepositoryInterface;

final class DeleteCastMemberUseCase
{
    public function __construct(
        private CastMemberRepositoryInterface $repository
    ) {
        //
    }

    public function execute(DTO\Deleted\Input $input): DTO\Deleted\Output
    {
        $repo = $this->repository->findById($input->id);
        $ret = $this->repository->delete($repo);

        return new DTO\Deleted\Output(
            success: $ret
        );
    }
}
