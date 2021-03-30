<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {

    private User $user;

    public function __construct(User $user)
    {
      $this->user = $user;  
    }
    /**
     * Receive a ID and return user
     * @param int $id
     */
    public function findById(int $id) {
        return $this->user->find($id);
    }

    /**
     * Return all users
     * @return array
     */
    public function findAll() {
        return $this->user->paginate();
    }

    public function findUserByEmailOrCPFCNPJ(string $email, string $cpf_cnpj) {
        return $this->user
        ->where('email', $email)
        ->orWhere('cpf_cnpj', $cpf_cnpj)
        ->first();
    }
    /**
     * Receive a user, create and return it
     * @param User $user
     */
    public function create(array $user) {
        return $this->user->create($user);
    }

    /**
     * Método responsável por atualizar a User
     */
    public function update(array $user, int $id) {
        return $this->user->find($id)->update($user);
    }

     /**
     * Método responsável por deletar a User
     */
    public function delete(int $id) {
        return $this->user->find($id)->delete();
    }
}