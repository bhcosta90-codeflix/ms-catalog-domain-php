<?php

namespace Tests\Unit\Utils\Notifications;

use Costa\Core\Utils\Notifications\DomainNotification;
use PHPUnit\Framework\TestCase;

class DomainNotificationUnitTest extends TestCase
{
    public function testGetErrors()
    {
        $notification = new DomainNotification;
        $errors = $notification->getErros();
        $this->assertIsArray($errors);
    }

    public function testAddErrors()
    {
        $notification = new DomainNotification;
        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required'
        ]);
        $errors = $notification->getErros();
        $this->assertCount(1, $errors);
    }

    public function testHasErrors()
    {
        $notification = new DomainNotification;
        $this->assertFalse($notification->hasError());

        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required'
        ]);
        $this->assertTrue($notification->hasError());
    }

    public function testMessage()
    {
        $notification = new DomainNotification;
        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required'
        ]);

        $notification->addError([
            'context' => 'description',
            'message' => 'description is required'
        ]);

        $this->assertIsString($notification->message());
        $this->assertEquals(
            'video: video title is required, description: description is required',
            $notification->message()
        );

        $this->assertEquals(
            'video: video title is required, description: description is required',
            (string) $notification
        );
    }

    public function testMessageFilterContext()
    {
        $notification = new DomainNotification;
        
        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required'
        ]);

        $notification->addError([
            'context' => 'description',
            'message' => 'description is required'
        ]);

        $notification->addError([
            'context' => 'category',
            'message' => 'category title is required'
        ]);

        $this->assertCount(3, $notification->getErros());

        $this->assertEquals(
            'video: video title is required',
            $notification->message(context: 'video')
        );
    }

    public function testToArray()
    {
        $notification = new DomainNotification;
        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required'
        ]);

        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required 2'
        ]);

        $this->assertIsArray($notification->toArray());

        $this->assertEquals([
            'video' => [
                'video title is required',
                'video title is required 2'
            ]
        ], $notification->toArray());
    }

    public function testToArrayFilter()
    {
        $notification = new DomainNotification;
        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required'
        ]);

        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required 2'
        ]);

        $notification->addError([
            'context' => 'category',
            'message' => 'category is required'
        ]);

        $this->assertIsArray($notification->toArray());

        $this->assertEquals([
            'video' => [
                'video title is required',
                'video title is required 2'
            ],
            'category' => [
                'category is required',
            ]
        ], $notification->toArray());
        
        $this->assertEquals([
            'video' => [
                'video title is required',
                'video title is required 2'
            ]
        ], $notification->toArray(context: 'video'));
    }
}
