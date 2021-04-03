<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notification;

class NotificationTest extends TestCase
{
    /**
     * Test to find all notifications
     *
     * /notifications [GET]
     * @return void
     */
    public function testShouldReturnAllNotifications(){
        $response = $this->call('GET', 'api/notifications');
        $this->assertEquals(200, $response->original['status']);
    }

     /**
     * A notification must return 
     * /notifications/id [GET]
     * @return void
     */
    public function testShouldReturnANotification()
    {
        $notification = Notification::factory()->create();

        $response = $this->call('GET', 'api/notifications/'.$notification->id);

        $this->assertEquals($notification->referece_type, $response->original['notification']['referece_type']);
        $this->assertEquals(200, $response->original['status']);
    }

    /**
     * A notification not must return 
     * /notifications/id [GET]
     * @return void
     */
    public function testNotShouldReturnANotification()
    {
        $response = $this->call('GET', 'api/notifications/99999999');
        $this->assertEquals(400, $response->original['status']);
    }

}
