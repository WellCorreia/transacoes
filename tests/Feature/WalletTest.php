<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;

class WalletTest extends TestCase
{
    /**
     * Test to find all wallets
     *
     * /wallets [GET]
     * @return void
     */
    public function testShouldReturnAllWallets(){
        $response = $this->call('GET', 'api/wallets');
        $this->assertEquals(200, $response->original['status']);
    }
    
    /**
     * A wallet must return 
     * /wallets/id [GET]
     * @return void
     */
    public function testShouldReturnWallet() {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create(['user_id' => $user->id]);

        $response = $this->call('GET', 'api/wallets/'.$wallet->id);

        $this->assertEquals($wallet->value, $response->original['wallet']['value']);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Must not return wallet
     * /wallets/id [GET]
     * @return void
     */
    public function testNotFoundWalletReturn() {
        $response = $this->call('GET', 'api/wallets/999999');
        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * A user must be created and a wallet to him
     * /wallets [POST]
     * @return void
     */
    public function testShouldCreateWallet(){
        $user = User::factory()->create();
        $wallet = Wallet::factory()->make(['user_id' => $user->id])->toArray();

        $response = $this->call('POST', 'api/wallets', $wallet);

        $this->assertEquals(201, $response->original['status']);
        $this->assertEquals($wallet['value'], $response->original['wallet']['value']);
    }
    /**
     * Must not be created a wallet, because not have user
     * /wallets [POST]
     * @return void
     */
    public function testNotShouldCreateWallet(){
        $wallet = Wallet::factory()->make(['user_id' => 32456])->toArray();
        
        $response = $this->call('POST', 'api/wallets', $wallet);
        $this->assertEquals(400, $response->original['status']);
    }
    /**
     * A wallet must be updated
     * /wallets/id [PUT]
     * @return void
     */
    public function testShouldUpdateWallet(){
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create(['user_id' => $user->id])->toArray();
        $wallet['value'] = 1500.00;

        $response = $this->call('PUT', 'api/wallets/'.$wallet['id'], $wallet);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Must not be update, because wallet not exist
     * /wallets/id [PUT]
     * @return void
     */
    public function testNotShouldUpdateWallet(){
        $wallet = Wallet::factory()->make()->toArray();
        $wallet['value'] = 42.00;

        $response = $this->call('PUT', 'api/wallets/9999999', $wallet);
        dump($wallet);
        dump($response);
        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * A user has must wallet
     * /wallets/id [DELETE]
     * @return void
     */
    public function testShouldDeleteWallet(){
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create(['user_id' => $user->id]);

        $response = $this->call('DELETE', 'api/wallets/'.$wallet->id);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Must not be deleted, because wallet not exist
     * /wallets/id [DELETE]
     * @return void
     */
    public function testNotShouldDeleteWallet(){
        $response = $this->call('DELETE', 'api/wallets/999999999');
        $this->assertEquals(400, $response->original['status']);
    }
}
