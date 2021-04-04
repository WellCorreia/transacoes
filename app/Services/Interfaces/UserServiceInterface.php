<?php

namespace App\Services\Interfaces;


interface UserServiceInterface
{
  public function findAll(): array;
  public function findById(int $id): array;
  public function createUserWithWallet(array $user): array;
  public function update(array $user, int $id): array;
  public function delete(int $id);
}