<?php

namespace Tests\Unit\UseCase\Category;

use Costa\Core\Domains\Entities\Category;
use PHPUnit\Framework\TestCase;

final class ListCategoryUserCaseUnitTest extends TestCase
{
    private Category $mockEntity;
    
    public function testGetById()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'teste de categoria';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
    }
}
