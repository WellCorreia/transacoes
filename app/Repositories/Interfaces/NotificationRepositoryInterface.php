<?php

namespace App\Repositories\Interfaces;


interface NotificationRepositoryInterface
{
  public function findAll();
  public function findById(int $id);
  public function create(array $transaction);
}