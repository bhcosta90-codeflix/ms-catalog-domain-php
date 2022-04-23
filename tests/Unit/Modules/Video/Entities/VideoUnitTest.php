<?php

namespace Tests\Unit\Video\Entities;

use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Modules\Video\Enums\Status;
use Costa\Core\Modules\Video\ValueObject\{Image, Media};
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
        $this->assertNull($entity->thumbFile?->path);
        $this->assertNull($entity->thumbHalf?->path);
        $this->assertNull($entity->trailerFile?->path);
        $this->assertNull($entity->trailerFile?->path);
        $this->assertNull($entity->videoFile?->path);
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

    public function testValueObjectImage()
    {
        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
            thumbFile: new Image('dakdopakd/teste.png')
        );

        $this->assertNotNull($entity->thumbFile);
        $this->assertInstanceOf(Image::class, $entity->thumbFile);
        $this->assertEquals('dakdopakd/teste.png', $entity->thumbFile->path);
    }

    public function testValueObjectImageToThumbHalf()
    {
        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
            thumbHalf: new Image('dakdopakd/teste.png')
        );

        $this->assertNotNull($entity->thumbHalf);
        $this->assertInstanceOf(Image::class, $entity->thumbHalf);
        $this->assertEquals('dakdopakd/teste.png', $entity->thumbHalf->path);
    }

    public function testValueObjectMedia()
    {
        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
            trailerFile: new Media('dakdopakd/teste.pm4')
        );

        $this->assertNotNull($entity->trailerFile);
        $this->assertInstanceOf(Media::class, $entity->trailerFile);
        $this->assertEquals('dakdopakd/teste.pm4', $entity->trailerFile->path);
        $this->assertEquals(Status::PENDING, $entity->trailerFile->status);
    }

    public function testValueObjectVideo()
    {
        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
            videoFile: new Media('dakdopakd/teste.pm4')
        );

        $this->assertNotNull($entity->videoFile);
        $this->assertInstanceOf(Media::class, $entity->videoFile);
        $this->assertEquals('dakdopakd/teste.pm4', $entity->videoFile->path);
        $this->assertEquals(Status::PENDING, $entity->videoFile->status);
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
