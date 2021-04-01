<?php
namespace Tests\Mocks;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepositoryMock implements UserRepositoryInterface
{
    const MOCK = [
        'name' => 'Ayrton',
        'password' => '123',
        'email' => 'teste@teste.ts',
        'type' => 'user',
        'register_code' => '111111111',
        'valor_wallet' => 15.7
    ];

    public function getAllUsers()
    {
        return [];
    }

    public function getUserById(int $id)
    {
        return new User(UserRepositoryMock::MOCK);
    }

    public function getUserByFilter(string $email, string $registerCode)
    {
        return [];
    }
    
     public function createUser(array $user)
    {
        $user = new User($user);
        $user->id = 1;
        return $user;
    }

    public function updateUser(object $user, array $userData)
    {
        return [];
    }
}