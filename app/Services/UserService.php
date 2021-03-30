<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
  private UserRepository $repository;

  public function __construct(UserRepository $userRepository)
  {
    $this->repository = $userRepository;
  }


  /**
   * Find all users
   * @return array
   */
  public function findAll() {
    try {
      $users = $this->repository->findAll();
      return [
        'status' => 200,
        'message' => 'Users founds',
        'users' => $users
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Find user by ID
   * @param int $id
   * @return array
   */
  public function findById(int $id) {
    try {
      $user = $this->repository->findById($id);
      if (!empty($user)) {
        return [
          'status' => 200,
          'message' => 'User found',
          'user' => $user
        ];
      }
      return [
        'status' => 400,
        'message' => 'User not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * find user by email and cpf_cnpj
   * @param string $email
   * @param string $cpf_cnpj
   * @return array
   */
  public function findUserByEmailOrCPFCNPJ(string $email, string $cpf_cnpj) {
    try {
      $users = $this->repository->findUserByEmailOrCPFCNPJ($email, $cpf_cnpj);
      if (!empty($user)) {
        return [
          'status' => 200,
          'message' => 'User found',
          'user' => $user
        ];
      }
      return [
        'status' => 400,
        'message' => 'User not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Create user
   * @param array $user
   * @return array
   */
  public function create(array $user) {
    try {
      $email = $user['email'];
      $cpf_cnpj = $user['cpf_cnpj'];

      $userExist = $this->repository->findUserByEmailOrCPFCNPJ($email, $cpf_cnpj);
      if (empty($userExist)) {
        $user = $this->repository->create($user);
        return [
          'status' => 201,
          'message' => 'Created user',
          'user' => $user
        ];  
      }
      return [
        'status' => 200,
        'message' => 'User already exist',
      ];  
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Update user
   * @param array $user
   * @param int $id
   * @return array
   */
  public function update(array $user, int $id) {
    try {
      $userExist = $this->repository->findById($id);
      if (!empty($userExist)) {
        $this->repository->update($user, $id);
        return [
          'status' => 200,
          'message' => 'User updated',
        ];
      }
      return [
        'status' => 400,
        'message' => 'User not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Delete user by id
   * @param int $id
   * @return array
   */
  public function delete(int $id) {
    try {
      $user = $this->repository->findById($id);
      if (!empty($user)) {
        $this->repository->delete($id);
        return [
          'status' => 200,
          'message' => 'User deleted',
        ];
      }
      return [
        'status' => 400,
        'message' => 'User not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }
}