<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface{

    private User $user;

    public function __construct(User $user)
    {
      $this->user = $user;  
    }
    /**
     * Receive a ID and return user
     * @param int $id
     * @return array
     */
    public function findById(int $id) {
        return $this->user->with('wallet')->find($id);
    }

    /**
     * Return all users
     * @return array
     */
    public function findAll() {
        return $this->user->with('wallet')->paginate();
    }

    /**
     * Return all users
     * @param string $email
     * @param string $cpf_cnpj
     * @return array
     */
    public function findUserByEmailOrCPFCNPJ(string $email, string $cpf_cnpj) {
        return $this->user
        ->where('email', $email)
        ->orWhere('cpf_cnpj', $cpf_cnpj)
        ->first();
    }
    /**
     * Receive a user, create and return it
     * @param array $user
     * @return array
     */
    public function create(array $user) {
        return $this->user->create($user);
    }

    /**
     * Receive a user and an ID, update it and return
     * @param array $user
     * @param int $id
     * @return array
     */
    public function update(array $user, int $id) {
        return $this->user->find($id)->update($user);
    }

     /**
     * Receive a ID and remove
     * @param int $id
     * @return boolean
     */
    public function delete(int $id) {
        return $this->user->find($id)->delete();
    }
}