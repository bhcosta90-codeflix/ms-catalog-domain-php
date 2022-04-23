<?php

namespace Tests\Unit\Video\Entities;

use PHPUnit\Framework\TestCase;
use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Utils\ValueObject\Uuid;
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

    public function testId()
    {
        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
        );

        $this->assertNotEmpty($entity->id());
    }

    public function testAddCategory(){
        $uuidCategory = UuidUuid::uuid4()->toString();
        $uuidCategory2 = UuidUuid::uuid4()->toString();

        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
        );

        $this->assertCount(0, $entity->categories);

        $entity->addCategory(id: $uuidCategory);
        $entity->addCategory(id: $uuidCategory2);

        $this->assertCount(2, $entity->categories);
    }

    public function testRemoveCategory(){
        $uuidCategory = UuidUuid::uuid4()->toString();
        $uuidCategory2 = UuidUuid::uuid4()->toString();

        $entity = new Video(
            title: 'teste',
            description: 'teste',
            yearLaunched: 2029,
            duration: 60,
            opened: true,
            rating: Rating::ER,
        );

        $entity->addCategory(id: $uuidCategory);
        $entity->addCategory(id: $uuidCategory2);
        $this->assertCount(2, $entity->categories);
        $entity->removeCategory(id: $uuidCategory);
        $this->assertCount(1, $entity->categories);
    }
}
