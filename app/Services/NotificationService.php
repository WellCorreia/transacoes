<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use App\Services\Interfaces\NotificationServiceInterface;
use DB;

class NotificationService implements NotificationServiceInterface
{
  protected $repository;
  protected $walletService;

  public function __construct(NotificationRepository $notificationRepository)
  {
    $this->repository = $notificationRepository;
  }

   /**
   * Find all notifications
   * @return array
   */
  public function findAll(): array {
    try {
      $notifications = $this->repository->findAll();
      return [
        'status' => 200,
        'message' => 'Notifications founds',
        'notifications' => $notifications
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

   /**
   * Find notification by ID
   * @param int $id
   * @return array
   */
  public function findById(int $id): array {
    try {
      $notification = $this->repository->findById($id);
      if (!empty($notification)) {
        return [
          'status' => 200,
          'message' => 'Notification found',
          'notification' => $notification
        ];
      }
      return [
        'status' => 400,
        'message' => 'Notification not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }
}