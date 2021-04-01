<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository {

    private Wallet $wallet;

    public function __construct(Wallet $wallet)
    {
      $this->wallet = $wallet;  
    }
    /**
     * Receive a ID and return wallet
     * @param int $id
     */
    public function findById(int $id) {
        return $this->wallet->find($id);
    }

    /**
     * Return all users
     * @return array
     */
    public function findAll() {
        return $this->wallet->paginate();
    }

    /**
     * Receive a wallet, create and return it
     * @param array $wallet
     * @return array
     */
    public function create(array $wallet) {
        return $this->wallet->create($wallet);
    }

    /**
     * Receive a wallet and an ID, update it and return
     * @param array $wallet
     * @param int $id
     * @return array
     */
    public function update(array $wallet, int $id) {
        return $this->wallet->find($id)->update($wallet);
    }

     /**
     * Receive a ID and remove
     * @param int $id
     * @return boolean
     */
    public function delete(int $id) {
        return $this->wallet->find($id)->delete();
    }
}