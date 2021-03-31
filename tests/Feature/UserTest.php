<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Test to find all users
     *
     * /users [GET]
     * @return void
     */
    public function testShouldReturnAllUsers(){
        $response = $this->call('GET', 'api/users');
        $this->assertEquals(200, $response->original['status']);
    }
    
    /**
     * A user must return 
     * /users/id [GET]
     * @return void
     */
    public function testShouldReturnUser() {
        $user = User::factory()->create();
        $response = $this->call('GET', 'api/users/'.$user->id);

        $this->assertEquals($user->cpf_cnpj, $response->original['user']['cpf_cnpj']);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Must not return user
     * /users/id [GET]
     * @return void
     */
    public function testNotFoundUserReturn() {
        $response = $this->call('GET', 'api/users/999999');
        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * A user must be created
     * /users [POST]
     * @return void
     */
    public function testShouldCreateUser(){
        $user = User::factory()->make()->toArray();
        $response = $this->call('POST', 'api/users', $user);

        $this->assertEquals(201, $response->original['status']);
        $this->assertEquals($user['cpf_cnpj'], $response->original['user']['cpf_cnpj']);
    }
    /**
     * Must not be created user, because already exist a with same cpf_cnpj
     * /users [POST]
     * @return void
     */
    public function testNotShouldCreateUser(){
        $user = User::factory()->create()->toArray();
        
        $response = $this->call('POST', 'api/users', $user);
        $this->assertEquals(400, $response->original['status']);
    }
    /**
     * A user must be updated
     * /users/id [PUT]
     * @return void
     */
    public function testShouldUpdateUser(){
        $user = User::factory()->create()->toArray();
        $user['name'] = 'update';

        $response = $this->call('PUT', 'api/users/'.$user['id'], $user);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Must not be update, because user not exist
     * /users/id [PUT]
     * @return void
     */
    public function testNotShouldUpdateUser(){
        $user = User::factory()->make()->toArray();
        $user['name'] = 'error';

        $response = $this->call('PUT', 'api/users/9999999', $user);
        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * A user must be deleted
     * /users/id [DELETE]
     * @return void
     */
    public function testShouldDeleteMarca(){
        $user = User::factory()->create();

        $response = $this->call('DELETE', 'api/users/'.$user->id);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Must not be deleted, because user not exist
     * /users/id [DELETE]
     * @return void
     */
    public function testNotShouldDeleteMarca(){
        $response = $this->call('DELETE', 'api/users/999999999');
        $this->assertEquals(400, $response->original['status']);
    }
}
