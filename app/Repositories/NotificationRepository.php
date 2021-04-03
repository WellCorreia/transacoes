<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface{

    private Notification $notification;

    public function __construct(Notification $notification)
    {
      $this->notification = $notification;  
    }
    /**
     * Receive a ID and return notification
     * @param int $id
     * @return array
     */
    public function findById(int $id) {
        return $this->notification->find($id);
    }

    /**
     * Return all notifications
     * @return array
     */
    public function findAll() {
        return $this->notification->paginate();
    }

    /**
     * Receive a notification
     * @param array $notification
     * @return array
     */
    public function create(array $notification) {
        return $this->notification->create($notification);
    }
}