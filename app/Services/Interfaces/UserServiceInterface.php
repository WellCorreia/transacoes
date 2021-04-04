<?php

namespace App\Services\Interfaces;


interface UserServiceInterface
{
  public function findAll();
  public function findById(int $id);
  public function createUserWithWallet(array $user);
  public function update(array $user, int $id);
  public function delete(int $id);
}