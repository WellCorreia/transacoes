<?php

namespace App\Repositories\Interfaces;


interface WalletRepositoryInterface
{
  public function findAll();
  public function findById(int $id);
  public function create(array $wallet);
  public function update(array $wallet, int $id);
  public function delete(int $id);
}