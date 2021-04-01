<?php

namespace App\Services;

use App\Repositories\WalletRepository;
use App\Services\UserService;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
  protected $repository;

  public function __construct(WalletRepository $walletRepository)
  {
    $this->repository = $walletRepository;
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
        'wallets' => $wallets
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
      $wallet = $this->repository->create($wallet);
      return [
        'status' => 201,
        'message' => 'Created wallet',
        'wallet' => $wallet
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