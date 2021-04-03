<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Services\WalletService;
use App\Services\UserService;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\WalletServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Facades\Http;
use DB;
use Exception;

class TransactionService implements TransactionServiceInterface
{
  protected TransactionRepository $repository;
  protected UserService $userService;
  protected WalletService $walletService;

  public function __construct(
    TransactionRepository $transactionRepository,
    UserService $userService,
    WalletService $walletService
    )
    {
      $this->repository = $transactionRepository;
      $this->userService = $userService;
      $this->walletService = $walletService;
    }

  /**
   * Find all transactions
   * @return array
   */
  public function findAll(): array {
    try {
      $transactions = $this->repository->findAll();
      return [
        'status' => 200,
        'message' => 'Transactions founds',
        'transactions' => $transactions
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Find transaction by ID
   * @param int $id
   * @return array
   */
  public function findById(int $id): array {
    try {
      $transaction = $this->repository->findById($id);
      if (!empty($transaction)) {
        return [
          'status' => 200,
          'message' => 'Transaction found',
          'transaction' => $transaction
        ];
      }
      return [
        'status' => 400,
        'message' => 'Transaction not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

   /**
   * Create transaction
   * @param array $transaction
   * @return array
   */
  public function create(array $transaction): array {

    return DB::transaction(function () use ($transaction) {
      try {
        $payer = $this->userService->findById($transaction['payer_id']);
        $payee = $this->userService->findById($transaction['payee_id']);

        if ($payer['status'] != 200 || $payee['status'] != 200) {
          return ['status' => 400, 'message' => "Payer or Payee invalid"];
        }
        
        if ($payer['user']['type'] == 'shopkeeper') {
          return [ 'status' => 400, 'message' => "Shopkeepers cannot be payer"];
        }

        $payerDebit = $this->walletService->subtractWalletValue($payer['user']['wallet']['id'], $transaction['value']);
        $payeeCredit = $this->walletService->sumWalletValue($payee['user']['wallet']['id'], $transaction['value']);

        if (!$this->externalAuthorizingService()) {
          return [ 'status' => 400, 'message' => "Unauthorized external service"];
        }

        DB::commit();
        return [
          'status' => 201, 
          'message' => "Create transaction",
        ];
      } catch (\Throwable $th) {
        DB::rollback();
        return [
          'status' => $th->getStatusCode(), 
          'message' => $th->getMessage()
        ];
      }

    });
  }

  private function externalAuthorizingService() {
    $response = json_decode(Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6')->body(), true);
    return $response['message'] == 'Autorizado';
  }

  /**
   * Delete transaction by id
   * @param int $id
   * @return array
   */
  public function delete(int $id) {
    try {
      $transaction = $this->repository->findById($id);
      if (!empty($transaction)) {
        $this->repository->delete($id);
        return [
          'status' => 200,
          'message' => 'Transaction deleted',
        ];
      }
      return [
        'status' => 400,
        'message' => 'Transaction not found',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

}