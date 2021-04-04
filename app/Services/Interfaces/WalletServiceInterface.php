<?php

namespace App\Services\Interfaces;

interface WalletServiceInterface
{
  public function findAll(): array;
  public function findById(int $id): array;
  public function create(array $wallet): array;
  public function update(array $wallet, int $id): array;
  public function delete(int $id);
}