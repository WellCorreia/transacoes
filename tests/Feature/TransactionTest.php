<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
class TransactionTest extends TestCase
{
    /**
     * Test to find all transactions
     *
     * /transactions [GET]
     * @return void
     */
    public function testShouldReturnAllTransactions(){
        $response = $this->call('GET', 'api/transactions');
        $this->assertEquals(200, $response->original['status']);
    }

     /**
     * A user must return 
     * /transactions/id [GET]
     * @return void
     */
    public function testShouldReturnATransaction()
    {
        
        $userPayer = User::factory()->create();
        $walletPayer = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 200.00,
            ]);

        $userPayee = User::factory()->create();
        $walletPayee = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 25.00,
            ]);

        $transaction  = Transaction::factory()->create([
            'payer_id' => $userPayer->id,
            'payee_id' => $userPayer->id,
            'value' => 25.00,
            ]);

        $response = $this->call('GET', 'api/transactions/'.$transaction->id);

        $this->assertEquals($transaction->value, $response->original['transaction']['value']);
        $this->assertEquals(200, $response->original['status']);
    }

    /**
     * A transaction must be carried out
     * /transactions [POST]
     * @return void
     */
    public function testATransactionShouldMustBeCarriedOut()
    {
        
        $userPayer = User::factory()->create();
        $walletPayer = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 200.00,
            ]);

        $userPayee = User::factory()->create();
        $walletPayee = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 25.00,
            ]);

        $transaction  = Transaction::factory()->create([
            'payer_id' => $userPayer->id,
            'payee_id' => $userPayer->id,
            'value' => 25.00,
            ]);

        $response = $this->call('POST', 'api/transactions');

        $this->assertEquals(200, $response->original['status']);
    }

    /**
     * A transaction must not be carried out. payer without balance
     * /transactions [POST]
     * @return void
     */
    public function testATransactionNotShouldMustBeCarriedOutPayerWithoutBalance()
    {
        
        $userPayer = User::factory()->create();
        $walletPayer = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 50.00,
            ]);

        $userPayee = User::factory()->create();
        $walletPayee = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 25.00,
            ]);

        $transaction  = Transaction::factory()->create([
            'payer_id' => $userPayer->id,
            'payee_id' => $userPayer->id,
            'value' => 150.00,
            ]);

        $response = $this->call('POST', 'api/transactions');

        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * A transaction must not be carried out. payer is shopkeeper
     * /transactions [POST]
     * @return void
     */
    public function testATransactionNotShouldMustBeCarriedOutPayerIsShopkeeper()
    {
        
        $userPayer = User::factory()->create(['type' => 'shopkeeper']);
        $walletPayer = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 50.00,
            ]);

        $userPayee = User::factory()->create();
        $walletPayee = Wallet::factory()->create([
            'user_id' => $userPayer->id,
            'value' => 25.00,
            ]);

        $transaction  = Transaction::factory()->create([
            'payer_id' => $userPayer->id,
            'payee_id' => $userPayer->id,
            'value' => 150.00,
            ]);

        $response = $this->call('POST', 'api/transactions');

        $this->assertEquals(400, $response->original['status']);
    }
}
