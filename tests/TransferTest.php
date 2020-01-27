<?php

namespace Kopokopo\SDK\Tests;

require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use Kopokopo\SDK\TransferService;

class TransferTest extends TestCase
{
    public function setup()
    {
        $this->clientId = 'your_client_id';
        $this->clientSecret = '10af7ad062a21d9c841877f87b7dec3dbe51aeb3';

        /*
        *    createSettlementAccount() setup
        */

        // Headers to be returned by the createSettlementAccount() mock
        $settlementAccountHeaders = file_get_contents(__DIR__.'/Mocks/settlementAccountHeaders.json');

        // Create an instance of MockHandler for returning responses for createSettlementAccount()
        $settlementAccountMock = new MockHandler([
            new Response(201, json_decode($settlementAccountHeaders, true)),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementAccountHandler = HandlerStack::create($settlementAccountMock);

        // Create a new instance of client using the createSettlementAccount() handler
        $settlementAccountClient = new Client(['handler' => $settlementAccountHandler]);

        // Use $settlementAccountClient to create an instance of the TransferService() class
        $this->settlementAccountClient = new TransferService($settlementAccountClient, $this->clientId, $this->clientSecret);

        /*
        *    settleFunds() setup
        */

        // Headers to be returned by the settleFunds() mock
        $settleFundsHeaders = file_get_contents(__DIR__.'/Mocks/settleFundsHeaders.json');

        // Create an instance of MockHandler for returning responses for settleFunds()
        $settleFundsMock = new MockHandler([
            new Response(201, json_decode($settleFundsHeaders, true)),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settleFundsHandler = HandlerStack::create($settleFundsMock);

        // Create a new instance of client using the settleFunds() handler
        $settleFundsClient = new Client(['handler' => $settleFundsHandler]);

        // Use $settleFundsClient to create an instance of the TransferService() class
        $this->settleFundsClient = new TransferService($settleFundsClient, $this->clientId, $this->clientSecret);

        /*
        *    settlementAccountStatus() setup
        */

        // json response to be returned
        $settlementAccountStatusBody = file_get_contents(__DIR__.'/Mocks/transfer-account-status.json');

        // Create an instance of MockHandler for returning responses for settlementAccountStatus()
        $settlementAccountStatusMock = new MockHandler([
            new Response(200, [], $settlementAccountStatusBody),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementAccountStatusHandler = HandlerStack::create($settlementAccountStatusMock);

        // Create a new instance of client using the settlementAccountStatus() handler
        $settlementAccountStatusClient = new Client(['handler' => $settlementAccountStatusHandler]);

        // Use$settlementAccountStatusClient to create an instance of the TransferService() class
        $this->settlementAccountStatusClient = new TransferService($settlementAccountStatusClient, $this->clientId, $this->clientSecret);

        /*
        *    settlementStatus() setup
        */

        // json response to be returned
        $settlementStatusBody = file_get_contents(__DIR__.'/Mocks/transfer-status.json');

        // Create an instance of MockHandler for returning responses for settlementStatus()
        $settlementStatusMock = new MockHandler([
            new Response(200, [], $settlementStatusBody),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementStatusHandler = HandlerStack::create($settlementStatusMock);

        // Create a new instance of client using the settlementStatus() handler
        $settlementStatusClient = new Client(['handler' => $settlementStatusHandler]);

        // Use$statusClient to create an instance of the TransferService() class
        $this->settlementStatusClient = new TransferService($settlementStatusClient, $this->clientId, $this->clientSecret);
    }

    /*
    *   Create Settlement account tests
    */

    public function testCreateSettlementAccountSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settlementAccountClient->createSettlementAccount([
                'accountName' => 'my_account_name',
                'bankRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementAccountWithNoAccountNameFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accountName'],
            $this->settlementAccountClient->createSettlementAccount([
                'bankRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementAccountWithNoBankRefFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the bankRef'],
            $this->settlementAccountClient->createSettlementAccount([
                'accountName' => 'my_account_name',
                'bankBranchRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementAccountWithNoBankBranchRefFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the bankBranchRef'],
            $this->settlementAccountClient->createSettlementAccount([
                'accountName' => 'my_account_name',
                'bankRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementAccountWithNoAccountNumberFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accountNumber'],
            $this->settlementAccountClient->createSettlementAccount([
                'accountName' => 'my_account_name',
                'bankRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementAccountWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementAccountClient->createSettlementAccount([
                'accountName' => 'my_account_name',
                'bankRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchRef' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
            ])
        );
    }

    /*
    *   Settle Funds tests
    */

    public function testSettleFundsSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settleFundsClient->settleFunds([
                'amount' => 333,
                'currency' => 'KES',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettleFundsWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settleFundsClient->settleFunds([
                'amount' => 333,
                'currency' => 'KES',
            ])
        );
    }

    public function testSettleFundsWithNoAmountFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the amount'],
            $this->settleFundsClient->settleFunds([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
                'currency' => 'KES',
            ])
        );
    }

    public function testSettleFundsWithNoCurrencyFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the currency'],
            $this->settleFundsClient->settleFunds([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
                'amount' => 333,
            ])
        );
    }

    /*
    *   Settlement Account Status tests
    */

    public function testSettlementAccountStatusSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settlementAccountStatusClient->settlementAccountStatus([
                'location' => 'my_request_id',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementAccountStatusWithNoLocationFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the location'],
            $this->settlementAccountStatusClient->settlementAccountStatus([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementAccountStatusWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementAccountStatusClient->settlementAccountStatus([
                'location' => 'my_request_id',
            ])
        );
    }

    /*
    *   Settlement Status tests
    */

    public function testSettlementStatusSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settlementStatusClient->settlementStatus([
                'location' => 'my_request_id',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementStatusWithNoLocationFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the location'],
            $this->settlementStatusClient->settlementStatus([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementStatusWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementStatusClient->settlementStatus([
                'location' => 'my_request_id',
            ])
        );
    }
}
