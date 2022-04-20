<?php

namespace Tests\Unit\Domains\Entities;

use Costa\Core\Domains\Entities\CastMember;
use Costa\Core\Domains\Enums\CastMemberType;
use Costa\Core\Domains\Exceptions\EntityValidationException;
use Costa\Core\Domains\ValueObject\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CastMemberUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new CastMember(
            name: "teste",
            isActive: true,
            type: CastMemberType::ACTOR,
        );

        $this->assertNotEmpty($category->id());
        $this->assertEquals('teste', $category->name);
        $this->assertEquals(CastMemberType::ACTOR, $category->type);
        $this->assertTrue($category->isActive);
        $this->assertNotEmpty($category->createdAt());
    }

    public function testDisabled()
    {
        $category = new CastMember(
            name: "teste",
            type: CastMemberType::ACTOR,
        );

        $this->assertTrue($category->isActive);

        $category->disable();

        $this->assertFalse($category->isActive);
    }

    public function testEnabled()
    {
        $category = new CastMember(
            name: "teste",
            type: CastMemberType::ACTOR,
            isActive: false
        );

        $this->assertFalse($category->isActive);

        $category->enable();

        $this->assertTrue($category->isActive);
    }

    public function testChangeType()
    {
        $category = new CastMember(
            name: "teste",
            type: CastMemberType::ACTOR,
            isActive: false
        );
        
        $category->changeType(CastMemberType::DIRECTOR);

        $this->assertEquals(CastMemberType::DIRECTOR, $category->type);

    }

    public function testUpdate()
    {

        $uuid = Uuid::random();

        $category = new CastMember(
            id: $uuid,
            type: CastMemberType::ACTOR,
            name: "teste",
            isActive: true,
            createdAt: '2022-01-01 00:00:00'
        );

        $category->update(
            name: "new_name",
        );

        $this->assertEquals('new_name', $category->name);

        $category->update(
            name: "new_name 2",
        );

        $this->assertEquals($uuid, $category->id);
        $this->assertEquals('new_name 2', $category->name);
        $this->assertEquals('2022-01-01 00:00:00', $category->createdAt());
    }

    public function testExceptionCreateMinName()
    {
        $this->expectException(EntityValidationException::class);

        new CastMember(
            type: CastMemberType::ACTOR,
            name: "t",
            isActive: true
        );
    }

    public function testExceptionCreateMaxName()
    {
        $this->expectException(EntityValidationException::class);

        new CastMember(
            type: CastMemberType::ACTOR,
            name: str_repeat("t", 256),
            isActive: true
        );
    }

    public function testExceptionUpdateMinName()
    {
        $this->expectException(EntityValidationException::class);

        $castMember = new CastMember(
            type: CastMemberType::ACTOR,
            name: "t12356",
            isActive: true
        );

        $castMember->update(
            name: 'a'
        );
    }

    public function testExceptionUpdateMaxName()
    {
        $this->expectException(EntityValidationException::class);

        $castMember = new CastMember(
            type: CastMemberType::ACTOR,
            name: "t12356",
            isActive: true
        );

        $castMember->update(
            name: str_repeat("t", 256),
        );
    }
}
