<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use Prophecy\PhpUnit\ProphecyTrait;
use App\Services\WalletService;
use App\Repositories\WalletRepository;

use App\Exceptions\ObjectNotFoundException;
use App\Exceptions\FailTransactionException;

class WalletTest extends TestCase
{

    use ProphecyTrait;

    /**
     * Should create wallet.
     *
     * @return void
     */
    public function testShouldCreateWallet()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory(['user_id' => $user->id])->make()->toArray();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['create'])
                ->getMock();

        $repository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($wallet))
            ->willReturn(201);

        $walletService = new WalletService($repository);
        $novoWallet = $wallet;

        $response = $walletService->create($novoWallet);
        $this->assertEquals(201, $response['status']);
    }


    /**
     * Should updated wallet with debit value.
     *
     * @return void
     */
    public function testShouldUpdatedWalletWithDebitValue()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory([
            'user_id' => $user->id,
            'value' => 200
            ])->create();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['findById', 'update'])
                ->getMock();

        $repository->expects($this->exactly(2))
            ->method('findById')
            ->with($this->equalTo($wallet->id))
            ->willReturn($wallet);

        $repository->expects($this->once())
            ->method('update')
            // ->with($this->equalTo($wallet))
            ->willReturn($wallet);

        $walletService = new WalletService($repository);
        
        $response = $walletService->debitWalletValue($wallet->id, 21.00);

        $this->assertEquals(200, $response['status']);
    }

    /**
     * Not should updated wallet with debit value, wallet not found.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithDebitValueWalletNotFound()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory([
            'user_id' => $user->id,
            'value' => 200
        ])->make();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['findById'])
                ->getMock();

        $repository->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(500))
            ->willReturn(null);

        $walletService = new WalletService($repository);
        
        $this->expectException(ObjectNotFoundException::class);

        $response = $walletService->debitWalletValue(500, 21.00);
    }

    /**
     * Not should updated wallet with debit value, because value equal zero.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithDebitValueBecauseValueEqualZero()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory([
            'user_id' => $user->id,
            'value' => 200
        ])->create();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['findById'])
                ->getMock();

        $repository->expects($this->once())
            ->method('findById')
            ->with($this->equalTo($wallet->id))
            ->willReturn($wallet);

        $walletService = new WalletService($repository);
        
        $this->expectException(FailTransactionException::class);

        $response = $walletService->debitWalletValue($wallet->id, 0);
    }

    /**
     * Should updated wallet with credit value.
     *
     * @return void
     */
    public function testShouldUpdatedWalletWithValue()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory([
            'user_id' => $user->id,
            'value' => 200
            ])->create();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['findById', 'update'])
                ->getMock();

        $repository->expects($this->exactly(2))
            ->method('findById')
            ->with($this->equalTo($wallet->id))
            ->willReturn($wallet);

        $repository->expects($this->once())
            ->method('update')
            // ->with($this->equalTo($wallet))
            ->willReturn($wallet);

        $walletService = new WalletService($repository);
        
        $response = $walletService->creditWalletValue($wallet->id, 21.00);

        $this->assertEquals(200, $response['status']);
    }

    /**
     * Not should updated wallet with credit value, wallet not found.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithValueWalletNotFound()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory([
            'user_id' => $user->id,
            'value' => 200
        ])->make();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['findById'])
                ->getMock();

        $repository->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(500))
            ->willReturn(null);

        $walletService = new WalletService($repository);
        
        $this->expectException(ObjectNotFoundException::class);

        $response = $walletService->creditWalletValue(500, 21.00);
    }

    /**
     * Not should updated wallet with debit value, because value equal zero.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithValueBecauseValueEqualZero()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory([
            'user_id' => $user->id,
            'value' => 200
        ])->create();

        $repository = $this->getMockBuilder(WalletRepository::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->setMethods(['findById'])
                ->getMock();

        $repository->expects($this->once())
            ->method('findById')
            ->with($this->equalTo($wallet->id))
            ->willReturn($wallet);

        $walletService = new WalletService($repository);
        
        $this->expectException(FailTransactionException::class);

        $response = $walletService->creditWalletValue($wallet->id, 0);
    }
}
