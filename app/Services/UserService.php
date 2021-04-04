<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\WalletServiceInterface;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
  protected $repository;
  protected $walletService;

  public function __construct(UserRepositoryInterface $userRepository, WalletServiceInterface $walletService)
  {
    $this->repository = $userRepository;
    $this->walletService = $walletService;
  }

  /**
   * Find all users
   * @return array
   */
  public function findAll(): array {
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
  public function findById(int $id): array {
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
   * Create user and wallet
   * @param array $user with value wallet
   * @return array
   */
  public function createUserWithWallet(array $user): array {

    return DB::transaction(function () use ($user) {
      try {
        
        $email = $user['email'];
        $cpf_cnpj = $user['cpf_cnpj'];
        $userExist = $this->repository->findUserByEmailOrCPFCNPJ($email, $cpf_cnpj);
        if (empty($userExist)) {
          
          $userCreated = $this->repository->create($user);
          
          if (!empty($userCreated)) {
            $wallet = [
              'user_id' => $userCreated->id,
              'value' => $user['value_wallet'],
            ];
            
            $wallet = $this->walletService->create($wallet);

            if ($wallet['status'] != 201) {
              DB::rollback();
              return [
                'status' => $wallet['status'], 
                'message' => $wallet['message']
              ];
            }
            DB::commit();
            return [
              'status' => 201,
              'message' => 'Created user with wallet',
              'user' => $user
            ]; 
          }

        }
        return [
          'status' => 400,
          'message' => 'User already exist',
        ];
      
      } catch (\Throwable $th) {
        DB::rollback();
        
        return [
          'status' => 500, 
          'message' => $th->getMessage()
        ];
      }

    });
  }

  /**
   * Update user
   * @param array $user
   * @param int $id
   * @return array
   */
  public function update(array $user, int $id): array {
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