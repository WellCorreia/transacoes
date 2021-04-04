<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Services\NotificationService;
use App\Jobs\NotificationJob;

class NotificationTest extends TestCase
{
    /**
     * Should create notification.
     *
     * @return void
     */
    public function testShouldCreateNotification()
    {
        $notification = Notification::factory()->make()->toArray();
        $notificationWithId = $notification;
        $notificationWithId['id'] = 2;

        $repository = $this->getMockBuilder(NotificationRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['create'])
                ->getMock();

        $repository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($notification))
            ->willReturn($notificationWithId);

        $notificationJob = $this->getMockBuilder(NotificationJob::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->setMethods()
            ->getMock();


        $this->expectsJobs(NotificationJob::class);

        $notificationService = new NotificationService($repository, $notificationJob);

        $response = $notificationService->create($notification);
        
        $this->assertEquals(201, $response['status']);
    }
}
