<?php

namespace App\Services\Interfaces;


interface WalletServiceInterface
{
  public function findAll();
  public function findById(int $id);
  public function create(array $wallet);
  // public function update(array $wallet, int $id);
  public function delete(int $id);
}