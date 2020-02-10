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
        *    createMerchantBankAccount() setup
        */

        // Headers to be returned by the createMerchantAccount() mock
        $merchantBankAccountHeaders = file_get_contents(__DIR__.'/Mocks/merchantAccountHeaders.json');

        // Create an instance of MockHandler for returning responses for createMerchantAccount()
        $merchantBankAccountMock = new MockHandler([
            new Response(201, json_decode($merchantBankAccountHeaders, true)),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $merchantBankAccountHandler = HandlerStack::create($merchantBankAccountMock);

        // Create a new instance of client using the createMerchantBankAccount() handler
        $merchantBankAccountClient = new Client(['handler' => $merchantBankAccountHandler]);

        // Use $merchantBankAccountClient to create an instance of the TransferService() class
        $this->merchantBankAccountClient = new TransferService($merchantBankAccountClient, $this->clientId, $this->clientSecret);

         /*
        *    createMerchantWallet() setup
        */

        // Headers to be returned by the createMerchantWallet() mock
        $merchantWalletHeaders = file_get_contents(__DIR__.'/Mocks/merchantWalletHeaders.json');

        // Create an instance of MockHandler for returning responses for createMerchantWallet()
        $merchantWalletMock = new MockHandler([
            new Response(201, json_decode($merchantWalletHeaders, true)),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $merchantWalletHandler = HandlerStack::create($merchantWalletMock);

        // Create a new instance of client using the createMerchantWallet() handler
        $merchantWalletClient = new Client(['handler' => $merchantWalletHandler]);

        // Use $merchantWalletClient to create an instance of the TransferService() class
        $this->merchantWalletClient = new TransferService($merchantWalletClient, $this->clientId, $this->clientSecret);

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
        *    merchantBankAccountStatus() setup
        */

        // json response to be returned
        $merchantBankAccountStatusBody = file_get_contents(__DIR__.'/Mocks/merchant-account-status.json');

        // Create an instance of MockHandler for returning responses for merchantAccountStatus()
        $merchantBankAccountStatusMock = new MockHandler([
            new Response(200, [], $merchantBankAccountStatusBody),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $merchantBankAccountStatusHandler = HandlerStack::create($merchantBankAccountStatusMock);

        // Create a new instance of client using the merchantBankAccountStatus() handler
        $merchantBankAccountStatusClient = new Client(['handler' => $merchantBankAccountStatusHandler]);

        // Use$merchantBankAccountStatusClient to create an instance of the TransferService() class
        $this->merchantBankAccountStatusClient = new TransferService($merchantBankAccountStatusClient, $this->clientId, $this->clientSecret);

        /*
        *    merchantWalletStatus() setup
        */

        // json response to be returned
        $merchantWalletStatusBody = file_get_contents(__DIR__.'/Mocks/merchant-wallet-status.json');

        // Create an instance of MockHandler for returning responses for merchantWalletStatus()
        $merchantWalletStatusMock = new MockHandler([
            new Response(200, [], $merchantWalletStatusBody),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
        ]);

        // Assign the instance of MockHandler to a HandlerStack
        $merchantWalletStatusHandler = HandlerStack::create($merchantWalletStatusMock);

        // Create a new instance of client using the merchantWalletStatus() handler
        $merchantWalletStatusClient = new Client(['handler' => $merchantWalletStatusHandler]);

        // Use$merchantWalletStatusClient to create an instance of the TransferService() class
        $this->merchantWalletStatusClient = new TransferService($merchantWalletStatusClient, $this->clientId, $this->clientSecret);

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
    *   Create Merchant Bank account tests
    */

    public function testCreateMerchantBankAccountSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->merchantBankAccountClient->createMerchantBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantBankAccountWithNoAccountNameFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accountName'],
            $this->merchantBankAccountClient->createMerchantBankAccount([
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantBankAccountWithNoBankIdFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the bankId'],
            $this->merchantBankAccountClient->createMerchantBankAccount([
                'accountName' => 'my_account_name',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantBankAccountWithNoBankBranchIdFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the bankBranchId'],
            $this->merchantBankAccountClient->createMerchantBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantBankAccountWithNoAccountNumberFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accountNumber'],
            $this->merchantBankAccountClient->createMerchantBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantBankAccountWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->merchantBankAccountClient->createMerchantBankAccount([
                'accountName' => 'my_account_name',
                'bankId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'bankBranchId' => '9ed38155-7d6f-11e3-83c3-5404a6144203',
                'accountNumber' => '1234567890',
            ])
        );
    }

    /*
    *   Create Merchant wallet tests
    */

    public function testCreateMerchantWalletSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->merchantWalletClient->createMerchantWallet([
                'msisdn' => '+254725895598',
                'network' => 'Safaricom',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantWalletWithoutNetworkFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the network'],
            $this->merchantWalletClient->createMerchantWallet([
                'msisdn' => '+254725895598',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantWalletWithoutMsisdnFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the msisdn'],
            $this->merchantWalletClient->createMerchantWallet([
                'network' => 'Safaricom',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testCreateMerchantWalletWithoutAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->merchantWalletClient->createMerchantWallet([
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
    *   Merchant Bank Account Status tests
    */

    public function testMerchantAccountStatusSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->merchantBankAccountStatusClient->getStatus([
                'location' => 'my_request_id',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testMerchantAccountStatusWithNoLocationFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the location'],
            $this->merchantBankAccountStatusClient->getStatus([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testMerchantAccountStatusWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->merchantBankAccountStatusClient->getStatus([
                'location' => 'my_request_id',
            ])
        );
    }

    /*
    *   Merchant Wallet Status tests
    */

    public function testMerchantWalletStatusSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->merchantWalletStatusClient->getStatus([
                'location' => 'my_request_id',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testMerchantWalletStatusWithNoLocationFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the location'],
            $this->merchantWalletStatusClient->getStatus([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testMerchantWalletStatusWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->merchantWalletStatusClient->getStatus([
                'location' => 'my_request_id',
            ])
        );
    }

    /*
    *   Settle Funds Status tests
    */

    public function testSettlementStatusSucceeds()
    {
        $this->assertArraySubset(
            ['status' => 'success'],
            $this->settlementStatusClient->getStatus([
                'location' => 'my_request_id',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementStatusWithNoLocationFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the location'],
            $this->settlementStatusClient->getStatus([
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ])
        );
    }

    public function testSettlementStatusWithNoAccessTokenFails()
    {
        $this->assertArraySubset(
            ['data' => 'You have to provide the accessToken'],
            $this->settlementStatusClient->getStatus([
                'location' => 'my_request_id',
            ])
        );
    }
}
