<?php

namespace App\Repositories\Interfaces;


interface UserRepositoryInterface
{
  public function findAll();
  public function findById(int $id);
  public function findUserByEmailOrCPFCNPJ(string $email, string $cpf_cnpj);
  public function create(array $wallet);
  public function update(array $wallet, int $id);
  public function delete(int $id);
}