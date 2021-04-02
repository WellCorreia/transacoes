<?php

namespace App\Services\Interfaces;


interface TransactionServiceInterface
{
  public function findAll(): array;
  public function findById(int $id): array;
  public function create(array $transaction): array;
  public function delete(int $id);
}