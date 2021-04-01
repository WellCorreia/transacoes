<?php

namespace App\Services;

use App\Repositories\WalletRepository;

use App\Services\UserService;

class WalletService
{
  private WalletRepository $repository;
  private UserService $userService;

  public function __construct(WalletRepository $walletRepository, UserService $userService)
  {
    $this->repository = $walletRepository;
    $this->userService = $userService;
  }

  /**
   * Find all users
   * @return array
   */
  public function findAll() {
    try {
      $wallets = $this->repository->findAll();
      return [
        'status' => 200,
        'message' => 'Wallet founds',
        'users' => $wallets
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500,
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Find wallet by ID
   * @param int $id
   * @return array
   */
  public function findById(int $id) {
    try {
      $wallet = $this->repository->findById($id);
      if (!empty($wallet)) {
        return [
          'status' => 200,
          'message' => 'Wallet found',
          'wallet' => $wallet
        ];
      }
      return [
        'status' => 400,
        'message' => 'Wallet not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Create wallet
   * @param array $wallet
   * @return array
   */
  public function create(array $wallet) {
    try {
      $userExist = $this->userService->findById($wallet['user_id']);
      if ($userExist['status'] == 200) {
        $wallet = $this->repository->create($wallet);
        return [
          'status' => 201,
          'message' => 'Created wallet',
          'wallet' => $wallet
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
   * Update wallet
   * @param array $wallet
   * @param int $id
   * @return array
   */
  public function update(array $wallet, int $id) {
    try {
      $userExist = $this->userService->findById($id);
      if ($userExist['status'] == 200) {
        $this->repository->update($wallet, $id);
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
   * Delete wallet by id
   * @param int $id
   * @return array
   */
  public function delete(int $id) {
    try {
      $wallet = $this->repository->findById($id);
      if (!empty($wallet)) {
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