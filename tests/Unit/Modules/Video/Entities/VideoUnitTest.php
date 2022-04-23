<?php

namespace Tests\Unit\Video\Entities;

use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;
use Ramsey\Uuid\Uuid as UuidUuid;

class VideoUnitTest extends TestCase
{
    public function testAttributes()
    {
        $entity = new Video(
            id: $id = Uuid::random(),
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
            createdAt: new DateTime('2022-01-01 00:00:00'),
        );

        $this->assertEquals($id, $entity->id());
        $this->assertEquals('teste', $entity->title);
        $this->assertEquals('teste', $entity->description);
        $this->assertEquals(2029, $entity->yearLaunched);
        $this->assertEquals(60, $entity->duration);
        $this->assertEquals(Rating::ER, $entity->rating);
        $this->assertTrue($entity->opened);
        $this->assertFalse($entity->published);
    }

    public function testIdAndCreatedAt()
    {
        $entity = $this->getEntity();

        $this->assertNotEmpty($entity->id());
        $this->assertNotEmpty($entity->createdAt());
    }

    public function testAddCategory()
    {
        $uuidCategory = UuidUuid::uuid4()->toString();
        $uuidCategory2 = UuidUuid::uuid4()->toString();

        $entity = $this->getEntity();

        $this->assertCount(0, $entity->categories);

        $entity->addCategory(id: $uuidCategory);
        $entity->addCategory(id: $uuidCategory2);

        $this->assertCount(2, $entity->categories);
    }

    public function testRemoveCategory()
    {
        $uuidCategory = UuidUuid::uuid4()->toString();
        $uuidCategory2 = UuidUuid::uuid4()->toString();

        $entity = $this->getEntity();

        $entity->addCategory(id: $uuidCategory);
        $entity->addCategory(id: $uuidCategory2);
        $this->assertCount(2, $entity->categories);
        $entity->removeCategory(id: $uuidCategory);
        $this->assertCount(1, $entity->categories);
    }

    public function testAddGenre()
    {
        $uuidGenre = UuidUuid::uuid4()->toString();
        $uuidGenre2 = UuidUuid::uuid4()->toString();

        $entity = $this->getEntity();

        $this->assertCount(0, $entity->genres);

        $entity->addGenre(id: $uuidGenre);
        $entity->addGenre(id: $uuidGenre2);

        $this->assertCount(2, $entity->genres);
    }

    public function testRemoveGenre()
    {
        $uuidGenre = UuidUuid::uuid4()->toString();
        $uuidGenre2 = UuidUuid::uuid4()->toString();

        $entity = $this->getEntity();

        $entity->addGenre(id: $uuidGenre);
        $entity->addGenre(id: $uuidGenre2);
        $this->assertCount(2, $entity->genres);
        $entity->removeGenre(id: $uuidGenre);
        $this->assertCount(1, $entity->genres);
    }

    public function testAddCastMember()
    {
        $uuidCastMember = UuidUuid::uuid4()->toString();
        $uuidCastMember2 = UuidUuid::uuid4()->toString();

        $entity = $this->getEntity();

        $this->assertCount(0, $entity->castMembers);

        $entity->addCastMember(id: $uuidCastMember);
        $entity->addCastMember(id: $uuidCastMember2);

        $this->assertCount(2, $entity->castMembers);
    }

    public function testRemoveCastMember()
    {
        $uuidCastMember = UuidUuid::uuid4()->toString();
        $uuidCastMember2 = UuidUuid::uuid4()->toString();

        $entity = $this->getEntity();

        $entity->addCastMember(id: $uuidCastMember);
        $entity->addCastMember(id: $uuidCastMember2);
        $this->assertCount(2, $entity->castMembers);
        $entity->removeCastMember(id: $uuidCastMember);
        $this->assertCount(1, $entity->castMembers);
    }

    private function getEntity()
    {
        return new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
        );
    }
}
