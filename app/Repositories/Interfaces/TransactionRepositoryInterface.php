<?php

namespace App\Repositories\Interfaces;


interface TransactionRepositoryInterface
{
  public function findAll();
  public function findById(int $id);
  public function create(array $transaction);
  // public function delete(int $id);
}