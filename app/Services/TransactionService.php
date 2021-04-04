<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Services\WalletService;
use App\Services\UserService;
use App\Services\NotificationService;
use App\Services\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
  protected TransactionRepository $repository;
  protected UserService $userService;
  protected WalletService $walletService;
  protected NotificationService $notificationService;

  public function __construct(
    TransactionRepository $transactionRepository,
    UserService $userService,
    WalletService $walletService,
    NotificationService $notificationService
    )
    {
      $this->repository = $transactionRepository;
      $this->userService = $userService;
      $this->walletService = $walletService;
      $this->notificationService = $notificationService;
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

        $check = $this->validateRequeridDatasTransaction($payer, $payee);
        if ($check['status'] == 400) {
          return $check;
        }

        $this->walletService->debitWalletValue($payer['user']['wallet']['id'], $transaction['value']);
        $this->walletService->creditWalletValue($payee['user']['wallet']['id'], $transaction['value']);

        $createdTransaction = $this->repository->create($transaction);

        $notification = $this->notificationService->builderNotification($payer['user'], $payee['user'], $createdTransaction);

        $createdNotification = $this->notificationService->create($notification);

        DB::commit();
        return [
          'status' => 201, 
          'message' => "Create transaction and send notification",
          'transaction' => $createdNotification
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

  /**
   * Check datas
   * @param array $payer
   * @param array $payee
   * @return array $result
   * 
   */
  public function validateRequeridDatasTransaction($payer, $payee): array {
    $result = [
      'status' => 200,
      'message' => ''
    ];
    
    if ($payer['status'] != 200 || $payee['status'] != 200) {
      $result = ['status' => 400, 'message' => "Payer or Payee invalid"];
    } 
    
    else if ($payer['user']['id'] == $payee['user']['id']) {
      $result = ['status' => 400, 'message' => "You cannot transfer to yourself"];
    }

    else if ($payer['user']['type'] == 'shopkeeper') {
      $result = [ 'status' => 400, 'message' => "Shopkeepers cannot be payer"];
    }
    
    if (!$this->externalAuthorizingService()) {
      $result = [ 'status' => 400, 'message' => "Unauthorized external service"];
    }

    return $result;
  }

  /**
   * Check autorizator
   * @return boolean
   */
  public function externalAuthorizingService() {
    $response = json_decode(Http::get(env('EXTERNAL_AUTORIZATOR_SERVICE'))->body(), true);
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