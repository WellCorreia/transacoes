<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\UserRepositoryInterface;

class TransactionRepository implements UserRepositoryInterface{

    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
      $this->transaction = $transaction;  
    }
    /**
     * Receive a ID and return transaction
     * @param int $id
     * @return array
     */
    public function findById(int $id) {
        return $this->transaction->with('payer', 'payee')->find($id);
    }

    /**
     * Return all transactions
     * @return array
     */
    public function findAll() {
        return $this->transaction->with('payer', 'payee')->paginate();
    }

    /**
     * Receive a transaction, create and return it
     * @param array $transaction
     * @return array
     */
    public function create(array $transaction) {
        return $this->transaction->create($transaction);
    }

     /**
     * Receive a ID and remove
     * @param int $id
     * @return boolean
     */
    public function delete(int $id) {
        return $this->transaction->find($id)->delete();
    }
}