<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Services\NotificationService;

class NotificationTest extends TestCase
{
    /**
     * Should create notification.
     *
     * @return void
     */
    public function testShouldCreateWallet()
    {
        $notification = Notification::factory()->make()->toArray();

        $repository = $this->getMockBuilder(NotificationRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['create'])
                ->getMock();

        $repository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($notification))
            ->willReturn(201);

        $notificationService = new NotificationService($repository);

        $response = $notificationService->create($notification);
        $this->assertEquals(201, $response['status']);
    }
}
