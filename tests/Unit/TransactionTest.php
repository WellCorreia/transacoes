<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TransactionService;

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
