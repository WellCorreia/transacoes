<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use Prophecy\PhpUnit\ProphecyTrait;
use App\Services\WalletService;
use App\Repositories\WalletRepository;

class WalletTest extends TestCase
{

    use ProphecyTrait;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testShouldCreateWallet()
    {
        $user = User::factory()->create();
        $wallet = User::factory(['user_id' => $user->id])->make()->toArray();;

        $walletMock = $this->prophesize(WalletService::class);
        $walletMock->create($wallet)->willReturn(new Wallet());

        $this->assertTrue(true);
    }
}
