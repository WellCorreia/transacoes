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
