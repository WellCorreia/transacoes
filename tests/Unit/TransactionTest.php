<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TransactionService;
use App\Models\User;

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

    /**
     * Should external authorizing service.
     *
     * @return void
     */
    public function testNotShouldValidateRequeridDatasTransactionPayerShopkeeper()
    {
        $payer = User::factory()->make(['type' => 'shopkeeper'])->toArray();
        $payee = User::factory()->make()->toArray();

        $payer['status'] = 200;
        $payer['payee'] = 200; 

        $service = $this->getMockBuilder(TransactionService::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $service->expects($this->once())
            ->method('validateRequeridDatasTransaction')
            ->with($this->equalTo($payer, $payee))
            ->willReturn([
                'status' => 400,
                'message' => "Shopkeepers cannot be payer"
            ]);

        $response = $service->validateRequeridDatasTransaction($payer, $payee);
        $this->assertEquals(400, $response['status']);
    }

    /**
     * Should external authorizing service.
     *
     * @return void
     */
    public function testNotShouldValidateRequeridDatasTransactionCanNotTransferToYourself()
    {
        $payer = User::factory()->make()->toArray();
        $payee = User::factory()->make()->toArray();

        $payer['status'] = 200;
        $payer['status'] = 200; 
        $payer['id'] = 5;
        $payer['id'] = 5; 

        $service = $this->getMockBuilder(TransactionService::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $service->expects($this->once())
            ->method('validateRequeridDatasTransaction')
            ->with($this->equalTo($payer, $payee))
            ->willReturn([
                'status' => 400, 
                'message' => "You cannot transfer to yourself"
            ]);

        $response = $service->validateRequeridDatasTransaction($payer, $payee);
        $this->assertEquals(400, $response['status']);
    }

    /**
     * Should external authorizing service.
     *
     * @return void
     */
    public function testNotShouldValidateRequeridDatasTransactionPayerOrPayeeInvalid()
    {
        $payer = User::factory()->make()->toArray();
        $payee = User::factory()->make()->toArray();

        $payer['status'] = 400;
        $payer['payee'] = 200; 

        $service = $this->getMockBuilder(TransactionService::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $service->expects($this->once())
            ->method('validateRequeridDatasTransaction')
            ->with($this->equalTo($payer, $payee))
            ->willReturn([
                'status' => 400,
                'message' => "Payer or Payee invalid"
            ]);

        $response = $service->validateRequeridDatasTransaction($payer, $payee);
        $this->assertEquals(400, $response['status']);
    }
}
