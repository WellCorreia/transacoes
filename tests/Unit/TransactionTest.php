<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\WalletService;
use App\Services\UserService;
use App\Services\TransactionService;
use App\Services\NotificationService;
use App\Repositories\TransactionRepository;

class TransactionTest extends TestCase
{
    /**
     * Should external authorizing service.
     *
     * @return void
     */
    public function testShouldExternalAuthorizingService()
    {
        $service = $this->getMockBuilder(TransactionService::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $service->expects($this->once())
            ->method('externalAuthorizingService')
            ->willReturn(true);

        $response = $service->externalAuthorizingService();
        $this->assertTrue($response);
    }
}
