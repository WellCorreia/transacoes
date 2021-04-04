<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use App\Services\Interfaces\NotificationServiceInterface;
use App\Jobs\NotificationJob;

class NotificationService implements NotificationServiceInterface
{
  protected $repository;
  protected $notificationJob;

  public function __construct(NotificationRepository $notificationRepository, NotificationJob $notificationJob)
  {
    $this->repository = $notificationRepository;
    $this->notificationJob = $notificationJob;
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

  /**
   * Create notification
   * @param array $notification
   * @return array
   */
  public function create(array $notification): array {
    try {
      $notification = $this->repository->create($notification);

      $id = $notification['id'];

      $this->notificationJob::dispatch($id)->afterCommit();

      return [
        'status' => 201,
        'message' => 'Created notification',
        'notification' => $notification
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Update notification
   * @param array $notification
   * @param int $id
   * @return array
   */
  public function update(array $notification, int $id): array {
    try {
      $notificationExist = $this->repository->findById($id);
      if (!empty($notificationExist)) {
        $this->repository->update($notification, $id);
        return [
          'status' => 200,
          'message' => 'Notification updated',
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

  /**
   * Builder notification
   * @param array $payer
   * @param array $payee
   * @param array $createdTransaction
   * @return array
   */
  public function builderNotification($payer, $payee, $createdTransaction): array {
    return [
      'type' => 'transaction',
      'reference_id' => $createdTransaction['id'],
      'data' => json_encode([
        'value' => $createdTransaction['value'],
        'from' => $payer['id'],
        'to' => $payee['id']
      ], true),
      'status' => 'pending'
    ];
  }
}