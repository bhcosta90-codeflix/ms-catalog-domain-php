<?php

namespace Tests\Unit\Domains\Entities;

use Costa\Core\Modules\Category\Entities\Category;
use Costa\Core\Utils\Domains\Exceptions\EntityValidationException;
use Costa\Core\Utils\Domains\ValueObject\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: "teste",
            description: "New desc",
            isActive: true
        );

        $this->assertNotEmpty($category->id());
        $this->assertEquals('teste', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
        $this->assertNotEmpty($category->createdAt());
    }

    public function testDisabled()
    {
        $category = new Category(
            name: "teste"
        );

        $this->assertTrue($category->isActive);

        $category->disable();

        $this->assertFalse($category->isActive);
    }

    public function testEnabled()
    {
        $category = new Category(
            name: "teste",
            isActive: false
        );

        $this->assertFalse($category->isActive);

        $category->enable();

        $this->assertTrue($category->isActive);
    }

    public function testUpdate()
    {

        $uuid = Uuid::random();

        $category = new Category(
            id: $uuid,
            name: "teste",
            description: "New desc",
            isActive: true,
            createdAt: '2022-01-01 00:00:00'
        );

        $category->update(
            name: "new_name",
            description: "new_desc"
        );

        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new_desc', $category->description);

        $category->update(
            name: "new_name 2",
            description: null
        );

        $this->assertEquals($uuid, $category->id);
        $this->assertEquals('new_name 2', $category->name);
        $this->assertEquals('2022-01-01 00:00:00', $category->createdAt());
        $this->assertNull($category->description);
    }

    public function testExceptionUuid()
    {
        $this->expectException(InvalidArgumentException::class);

        $uuid = 'hash.value';

        new Category(
            id: $uuid,
            name: "teste",
            description: "New desc",
            isActive: true
        );
    }

    public function testExceptionName()
    {
        $this->expectException(EntityValidationException::class);

        new Category(
            name: "t",
            description: "New desc",
            isActive: true
        );
    }

    public function testExceptionDescriptionMinLength()
    {
        $this->expectException(EntityValidationException::class);
        new Category(
            name: "teste",
            description: "1",
        );
    }

    public function testExceptionDescriptionMaxLength()
    {
        $this->expectException(EntityValidationException::class);
        new Category(
            name: "teste",
            description: str_repeat("1", 300),
        );
    }
}
