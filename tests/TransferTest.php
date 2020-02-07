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
        *    createSettlementBankAccount() setup
        */

        // Headers to be returned by the createSettlementAccount() mock
        $settlementBankAccountHeaders = file_get_contents(__DIR__.'/Mocks/settlementAccountHeaders.json');

        // Create an instance of MockHandler for returning responses for createSettlementAccount()
        $settlementBankAccountMock = new MockHandler([
            new Response(201, json_decode($settlementBankAccountHeaders, true)),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementBankAccountHandler = HandlerStack::create($settlementBankAccountMock);

        // Create a new instance of client using the createSettlementBankAccount() handler
        $settlementBankAccountClient = new Client(['handler' => $settlementBankAccountHandler]);

        // Use $settlementBankAccountClient to create an instance of the TransferService() class
        $this->settlementBankAccountClient = new TransferService($settlementBankAccountClient, $this->clientId, $this->clientSecret);

         /*
        *    createSettlementWallet() setup
        */

        // Headers to be returned by the createSettlementWallet() mock
        $settlementWalletHeaders = file_get_contents(__DIR__.'/Mocks/settlementWalletHeaders.json');

        // Create an instance of MockHandler for returning responses for createSettlementWallet()
        $settlementWalletMock = new MockHandler([
            new Response(201, json_decode($settlementWalletHeaders, true)),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementWalletHandler = HandlerStack::create($settlementWalletMock);

        // Create a new instance of client using the createSettlementWallet() handler
        $settlementWalletClient = new Client(['handler' => $settlementWalletHandler]);

        // Use $settlementWalletClient to create an instance of the TransferService() class
        $this->settlementWalletClient = new TransferService($settlementWalletClient, $this->clientId, $this->clientSecret);

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
        *    settlementBankAccountStatus() setup
        */

        // json response to be returned
        $settlementBankAccountStatusBody = file_get_contents(__DIR__.'/Mocks/merchant-account-status.json');

        // Create an instance of MockHandler for returning responses for settlementAccountStatus()
        $settlementBankAccountStatusMock = new MockHandler([
            new Response(200, [], $settlementBankAccountStatusBody),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementBankAccountStatusHandler = HandlerStack::create($settlementBankAccountStatusMock);

        // Create a new instance of client using the settlementBankAccountStatus() handler
        $settlementBankAccountStatusClient = new Client(['handler' => $settlementBankAccountStatusHandler]);

        // Use$settlementBankAccountStatusClient to create an instance of the TransferService() class
        $this->settlementBankAccountStatusClient = new TransferService($settlementBankAccountStatusClient, $this->clientId, $this->clientSecret);

        /*
        *    settlementWalletStatus() setup
        */

        // json response to be returned
        $settlementWalletStatusBody = file_get_contents(__DIR__.'/Mocks/merchant-wallet-status.json');

        // Create an instance of MockHandler for returning responses for settlementWalletStatus()
        $settlementWalletStatusMock = new MockHandler([
            new Response(200, [], $settlementWalletStatusBody),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $settlementWalletStatusHandler = HandlerStack::create($settlementWalletStatusMock);

        // Create a new instance of client using the settlementWalletStatus() handler
        $settlementWalletStatusClient = new Client(['handler' => $settlementWalletStatusHandler]);

        // Use$settlementWalletStatusClient to create an instance of the TransferService() class
        $this->settlementWalletStatusClient = new TransferService($settlementWalletStatusClient, $this->clientId, $this->clientSecret);

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
    *   Create Settlement Bank account tests
    */

    public function testCreateSettlementBankAccountSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settlementBankAccountClient->createSettlementBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementBankAccountWithNoAccountNameFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accountName'],
            $this->settlementBankAccountClient->createSettlementBankAccount([
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementBankAccountWithNoBankIdFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the bankId'],
            $this->settlementBankAccountClient->createSettlementBankAccount([
                'accountName' => 'my_account_name',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementBankAccountWithNoBankBranchIdFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the bankBranchId'],
            $this->settlementBankAccountClient->createSettlementBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementBankAccountWithNoAccountNumberFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accountNumber'],
            $this->settlementBankAccountClient->createSettlementBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementBankAccountWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementBankAccountClient->createSettlementBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
            ])
        );
    }

    /*
    *   Create Settlement wallet tests
    */

    public function testCreateSettlementWalletSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settlementWalletClient->createSettlementWalletAccount([
                'msisdn' => '+254725895598',
                'network' => 'Safaricom',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementWalletWithoutNetworkFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the network'],
            $this->settlementWalletClient->createSettlementWalletAccount([
                'msisdn' => '+254725895598',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementWalletWithoutMsisdnFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the msisdn'],
            $this->settlementWalletClient->createSettlementWalletAccount([
                'network' => 'Safaricom',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateSettlementWalletWithoutAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementWalletClient->createSettlementWalletAccount([
                'network' => 'Safaricom',
                'msisdn' => '+254725895598',
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
                'callbackUrl' => 'http://localhost:8000/test'
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
                'callbackUrl' => 'http://localhost:8000/test'
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
                'callbackUrl' => 'http://localhost:8000/test'
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
                'callbackUrl' => 'http://localhost:8000/test'
            ])
        );
    }

    public function testSettleFundsWithNoCallbackUrlSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settleFundsClient->settleFunds([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
                'currency' => 'KES',
                'amount' => 333,
                'callbackUrl' => 'http://localhost:8000/test'
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
            $this->settlementBankAccountStatusClient->settlementAccountStatus([
                'location' => 'my_request_id',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementAccountStatusWithNoLocationFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the location'],
            $this->settlementBankAccountStatusClient->settlementAccountStatus([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementAccountStatusWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementBankAccountStatusClient->settlementAccountStatus([
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
