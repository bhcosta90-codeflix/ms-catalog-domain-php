<?php

namespace Tests\Unit\Modules\Genre\Entities;

use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Genre\Entities\Genre;
use Costa\Core\Utils\Exceptions\EntityValidationException;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;
use Ramsey\Uuid\Uuid as UuidUuid;

class GenreUnitTest extends TestCase
{
    public function testAttributes()
    {
        $uuid = (string) UuidUuid::uuid4();
        $date = date('Y-m-d H:i:s');

        $genre = new Genre(
            id: new Uuid($uuid),
            name: 'New genre',
            createdAt: new DateTime($date),
            isActive: false
        );

        $this->assertEquals($uuid, $genre->id());
        $this->assertEquals('New genre', $genre->name);
        $this->assertFalse($genre->isActive);
        $this->assertEquals($date, $genre->createdAt());
    }

    public function testAttributesCreated()
    {
        $date = date('Y-m-d H:i:s');

        $genre = new Genre(
            name: 'New genre',
            createdAt: new DateTime($date),
            isActive: true
        );

        $this->assertNotEmpty($genre->id());
        $this->assertEquals('New genre', $genre->name);
        $this->assertTrue($genre->isActive);
        $this->assertEquals($date, $genre->createdAt());
    }

    public function testDisabled()
    {
        $genre = new Genre(
            name: "teste"
        );

        $this->assertTrue($genre->isActive);

        $genre->disable();

        $this->assertFalse($genre->isActive);
    }

    public function testEnabled()
    {
        $genre = new Genre(
            name: "teste",
            isActive: false
        );

        $this->assertFalse($genre->isActive);

        $genre->enable();

        $this->assertTrue($genre->isActive);
    }

    public function testUpdate()
    {

        $uuid = Uuid::random();

        $genre = new Genre(
            id: $uuid,
            name: "teste",
            isActive: true,
            createdAt: new DateTime()
        );

        $genre->update(
            name: "new_name",
        );

        $this->assertEquals('new_name', $genre->name);

        $genre->update(
            name: "new_name 2"
        );

        $this->assertEquals($uuid, $genre->id);
        $this->assertEquals('new_name 2', $genre->name);
        $this->assertNotEmpty($genre->createdAt());
    }

    public function testExceptionName()
    {
        $this->expectException(EntityValidationException::class);

        new Genre(
            name: "t",
            isActive: true
        );
    }

    public function testUpdateExceptionNameMin()
    {
        $this->expectException(EntityValidationException::class);

        $genre = new Genre(
            name: "teste",
            isActive: true
        );

        $genre->update(
            name: "t"
        );
    }

    public function testUpdateExceptionNameMax()
    {
        $this->expectException(EntityValidationException::class);

        $genre = new Genre(
            name: "teste",
            isActive: true
        );

        $genre->update(
            name: str_repeat('y', 256),
        );
    }

    public function testAddCategoryToGenre()
    {
        $idCategory = UuidUuid::uuid4();

        $genre = new Genre(
            name: "teste",
        );

        $this->assertIsArray($genre->categories);
        $this->assertCount(0, $genre->categories);
        $genre->addCategory(id: $idCategory);
        $genre->addCategory(id: $idCategory);
        $this->assertCount(2, $genre->categories);
    }

    public function testRemoveCategoryToGenre()
    {
        $idCategory = UuidUuid::uuid4();
        $idCategory2 = UuidUuid::uuid4();

        $genre = new Genre(
            name: "teste",
            categories: [
                $idCategory,
                $idCategory2
            ]
        );

        $this->assertCount(2, $genre->categories);
        $genre->removeCategory(id: $idCategory);
        $this->assertCount(1, $genre->categories);
        
        $this->assertEquals($idCategory2, $genre->categories[1]);
        
    }
}
