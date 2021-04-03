<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
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
     * Should updated wallet with subtract value.
     *
     * @return void
     */
    public function testShouldUpdatedWalletWithSubtractValue()
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
        
        $response = $walletService->subtractWalletValue($wallet->id, 21.00);

        $this->assertEquals(200, $response['status']);
    }

    /**
     * Not should updated wallet with subtract value, wallet not found.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithSubtractValueWalletNotFound()
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

        $response = $walletService->subtractWalletValue(500, 21.00);
    }

    /**
     * Not should updated wallet with subtract value, because value equal zero.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithSubtractValueBecauseValueEqualZero()
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

        $response = $walletService->subtractWalletValue($wallet->id, 0);
    }

    /**
     * Should updated wallet with sum value.
     *
     * @return void
     */
    public function testShouldUpdatedWalletWithSumValue()
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
        
        $response = $walletService->sumWalletValue($wallet->id, 21.00);

        $this->assertEquals(200, $response['status']);
    }

    /**
     * Not should updated wallet with sum value, wallet not found.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithSumValueWalletNotFound()
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

        $response = $walletService->sumWalletValue(500, 21.00);
    }

    /**
     * Not should updated wallet with subtract value, because value equal zero.
     *
     * @return void
     */
    public function testNotShouldUpdatedWalletWithSumValueBecauseValueEqualZero()
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

        $response = $walletService->sumWalletValue($wallet->id, 0);
    }
}
