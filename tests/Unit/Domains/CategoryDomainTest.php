<?php

namespace Tests\Unit\Domains;

use Costa\Core\Domains\Entities\CategoryDomain;
use Costa\Core\Domains\Exceptions\EntityValidationException;
use Costa\Core\Domains\ValueObject\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CategoryDomainTest extends TestCase
{
    public function testAttributes()
    {
        $category = new CategoryDomain(
            name: "teste",
            description: "New desc",
            isActive: true
        );

        $this->assertNotEmpty($category->id());
        $this->assertEquals('teste', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testDisabled()
    {
        $category = new CategoryDomain(
            name: "teste"
        );

        $this->assertTrue($category->isActive);

        $category->disable();

        $this->assertFalse($category->isActive);
    }

    public function testEnabled()
    {
        $category = new CategoryDomain(
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

        $category = new CategoryDomain(
            id: $uuid,
            name: "teste",
            description: "New desc",
            isActive: true
        );

        $category->update(
            name: "new_name",
            description: "new_desc"
        );

        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new_desc', $category->description);

        $category->update(
            name: "new_name",
            description: null
        );

        $this->assertEquals($uuid, $category->id);
        $this->assertEquals('new_name', $category->name);
        $this->assertNull($category->description);
    }

    public function testExceptionUuid()
    {
        $this->expectException(InvalidArgumentException::class);

        $uuid = 'hash.value';

        new CategoryDomain(
            id: $uuid,
            name: "teste",
            description: "New desc",
            isActive: true
        );
    }

    public function testExceptionName()
    {
        $this->expectException(EntityValidationException::class);

        new CategoryDomain(
            name: "t",
            description: "New desc",
            isActive: true
        );
    }

    public function testExceptionDescriptionMinLength()
    {
        $this->expectException(EntityValidationException::class);
        new CategoryDomain(
            name: "teste",
            description: "1",
        );
    }

    public function testExceptionDescriptionMaxLength()
    {
        $this->expectException(EntityValidationException::class);
        new CategoryDomain(
            name: "teste",
            description: str_repeat("1", 300),
        );
    }
}
