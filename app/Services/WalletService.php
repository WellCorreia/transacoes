<?php

namespace App\Services;

use App\Repositories\WalletRepository;
use App\Services\Interfaces\WalletServiceInterface;

use App\Exceptions\ObjectNotFoundException;
use App\Exceptions\FailTransactionException;
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
  public function findAll(): array {
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
  public function findById(int $id): array {
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
        'message' => 'Not found',
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
  public function create(array $wallet): array {
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
   * Update wallet by id
   * @param array $wallet
   * @param int $id
   * @return array
   */
  public function update(array $wallet, int $id): array {
    try {
      $walletExist = $this->repository->findById($id);
      if (!empty($walletExist)) {
        $wallet = $this->repository->update($wallet, $id);
        return [
          'status' => 200,
          'message' => 'Wallet Updated',
          'wallet' => $wallet
        ];
      }
      return [
        'status' => 400,
        'message' => 'Not found',
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
  public function delete(int $id): array {
    try {
      $wallet = $this->repository->findById($id);
      if (!empty($wallet)) {
        $this->repository->delete($id);
        return [
          'status' => 200,
          'message' => 'Wallet deleted',
        ];
      }
      return [
        'status' => 400,
        'message' => 'Not found wallet',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Debit wallet value
   * @param int $wallet_id
   * @param float $value
   * @return array
   */
  public function debitWalletValue(int $wallet_id, float $value): array {
      $wallet = $this->repository->findById($wallet_id);
      if (empty($wallet)) {
        throw new ObjectNotFoundException("Wallet not found");
      }

      if ($wallet->value < $value || $value <= 0) {
        throw new FailTransactionException("Insufficient wallet value a transaction");
      }
      
      $updateWallet = [
        'user_id' => $wallet['user_id'],
        'value' => $wallet['value'] - $value,
      ];

      return $this->update($updateWallet, $wallet_id);
  }

  /**
   * Credit wallet value
   * @param int $wallet_id
   * @param float $value
   * @return array
   */
  public function creditWalletValue(int $wallet_id, float $value): array {
      $wallet = $this->repository->findById($wallet_id);
      if (empty($wallet)) {
        throw new ObjectNotFoundException("Wallet not found");
      }

      if ($value <= 0) {
        throw new FailTransactionException("Insufficient wallet value a transaction");
      }

      $updateWallet = [
        'user_id' => $wallet['user_id'],
        'value' => $wallet['value'] + $value,
      ];
      
      return $this->update($updateWallet, $wallet_id);
  }
}