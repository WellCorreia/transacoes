<?php

namespace App\Services\Interfaces;

interface NotificationServiceInterface
{
  public function findAll(): array;
  public function findById(int $id): array;
  public function create(array $notification): array;
}