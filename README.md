# DISCLAIMER:

This is still in development. To connect to the current kopokopo's api check out it's documentation on <https://app.kopokopo.com/push_api>

# Kopokopo PHP SDK

This is a module to assist php developers in consuming Kopokopo's API

## Installation

You can install the PHP SDK via composer.

The recommended way to install the SDK is with Composer.

```
composer require kopokopo/k2-connect-php
```

## Initialisation

The package should be configured with your client id and client secret which you can get from your account on the kopokopo's app

```php
//Store your client id and client secret as environment variables

//Including the kopokopo sdk
use Kopokopo\SDK\K2;

$clientId = 'YOUR_CLIENT_ID'; // do not hard code this value
$clientSecret = 'YOUR_CLIENT_SECRET'; // do not hard code this value

$K2 = new K2($clientId, $clientSecret);
```

### After initialization, you can get instances of offered services as follows:

- [Tokens](#tokenservice) : `$tokens = $K2->TokenService();`
- [Webhooks](#webhooks) : `$webhooks = $K2->Webhooks();`
- [STK PUSH](#stkservice) : `$stk = $K2->StkService();`
- [Pay](#payservice) : `$pay = $K2->PayService();`
- [Transfer](#transferservice) : `$transfer = $K2->TransferService();`

## Usage

### Tokens

You will need to pass an access token when sending data to Kopokopo's API.

This will return an `access_token` and `expires_in` values

```php
use Kopokopo\SDK\K2;

$clientId = 'YOUR_CLIENT_ID'; // use 'sandbox' for development in the test environment
$clientSecret = 'YOUR_CLIENT_SECRET'; // use your sandbox app API key for development in the test environment
$baseUrl = 'api.kopokopo.com'; // Use appropriate url for the different environments
$K2 = new K2($clientId, $clientSecret, $baseUrl);

// Get one of the services
$tokens = $K2->TokenService();

// Use the service
$result = $tokens->getToken();
if($result['status'] == 'success'){
    $data = $result['data'];
    echo "My access token is: ".$data['access_token'];
    echo "It expires in: ".$data['expires_in'];
}

```

### Webhooks

- Consuming

```php
$router->map('POST', '/webhook', function () {
    global $K2;
    global $response;

    $webhooks = $K2->Webhooks();
    $webhookSecret = 'my_webhook_secret';

    $json_str = file_get_contents('php://input');

    $response = $webhooks->webhookHandler($json_str, $_SERVER['HTTP_X_KOPOKOPO_SIGNATURE'], $webhookSecret);

    echo json_encode($response);
});
```

- Subscription

```php
$webhooks = $K2->Webhooks();

//To subscribe to a webhook
$response = $webhooks->subscribe([
    'eventType' => 'buy_goods_received',
    'url' => 'http://localhost:8000/webhook',
    'webhookSecret' => 'my_webhook_secret',
    'scope' => 'Till',
    'scopeReference' => '555555',
    'accessToken' => 'my_access_token'
]);

if($response['status'] == 'success')
{
    echo "The resource location is:" . json_encode($response['location']);
}

```

### STK PUSH

```php
$stk = $K2->StkService();
$response = $stk->paymentRequest([
                'paymentChannel' => 'M-PESA',
                'tillNumber' => '13432',
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'phone' => '0712345678',
                'amount' => 3455,
                'email' => 'example@example.com',
                'callbackUrl' => 'http://localhost:8000/test',
                'accessToken' => 'myRand0mAcc3ssT0k3n',
            ]);
if($response['status'] == 'success')
{
    echo "The resource location is:" . json_encode($response['location']);
}
```

For other usage examples check out the [example app](https://github.com/NicoNjora/k2-connect-php-example).

## Services

The only supported ISO currency code at the moment is: `KES`

### `TokenService`

- `getToken()` to get an access token.

  - The response will contain: `token type`, `expires_in` and `access_token`

NB: The access token is required to send subsequent requests

### `StkService`

- `paymentRequest([ stkOptions ])`: `stkOptions`: An array of arrays containing the following keys:

  - `firstName`: Customer's first name `REQUIRED`
  - `lastName`: Customer's last name `REQUIRED`
  - `phone`: Phone number to pull money from. `REQUIRED`
  - `email`: Amount to charge.
  - `currency`: 3-digit ISO format currency code. `REQUIRED`
  - `amount`: Amount to charge. `REQUIRED`
  - `callbackUrl`: Amount to charge. `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`
  - `metadata`: It is an associative array containing a maximum of 5 key value pairs

- `getStatus(['location' => 'location', 'accessToken' => 'my_access_token' ])`:

   - `location`: The request location you get when you send a request `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`

For more information, please read <https://api-docs.kopokopo.com/#receive-payments-from-m-pesa-users-via-stk-push>

### `PayService`

- `addPayRecipient([ payRecipientOptions ])`: `payRecipientOptions`: An array of arrays containing the following keys:

  - `type`: Customer's first name `REQUIRED`
  - `firstName`: Pay recipient's first name `REQUIRED`
  - `lastName`: Pay recipient's last name `REQUIRED`
  - `phone`: Pay recipient's phone number `REQUIRED`
  - `email`: Pay recipient's email number
  - `network`: Pay recipient's network `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`

- `sendPay([ payOptions ])`: `payOptions`: An array of arrays containing the following keys:

  - `destination`: The destination `REQUIRED`
  - `currency`: 3-digit ISO format currency code. `REQUIRED`
  - `amount`: Amount to charge. `REQUIRED`
  - `callbackUrl`: Amount to charge. `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`
  - `metadata`: It is a hash containing a maximum of 5 key value pairs

- `getStatus(['location' => 'location', 'accessToken' => 'my_access_token' ])`:

  - `location`: The request location you get when you send a request `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`

For more information, please read <https://api-docs.kopokopo.com/#send-money-pay>

### `TransferService`

- `createMerchantBankAccount([ accountOpts ])`: `accountOpts`: An array of arrays containing the following keys:

  - `accountName`: Settlement Account Name `REQUIRED`
  - `bankRef`: Settlement Bank Reference `REQUIRED`
  - `bankBranchRef`: Settlement Bank Branch Reference `REQUIRED`
  - `accountNumber`: Settlement account number `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`
  
- `createMerchantWallet([ accountOpts ])`: `accountOpts`: An array of arrays containing the following keys:

  - `network`: The mobile wallet's account `REQUIRED`
  - `msisdn`: Msisdn(Phone number with the country code) `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`


- `settleFunds([ settleOpts ])`: `settleOpts`: An array of arrays containing the following keys:

  - `destination`: The destination `REQUIRED FOR A TARGETED TRANSFER`
  - `currency`: 3-digit ISO format currency code. `REQUIRED`
  - `amount`: Amount to charge. `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`

- `getStatus(['location' => 'location', 'accessToken' => 'my_access_token' ])`:

  - `location`: The request location you get when you send a request `REQUIRED`
  - `accessToken`: Gotten from the [`TokenService`](#tokenservice) response `REQUIRED`

For more information, please read [api-docs#transfer](https://api-docs.kopokopo.com/#transfer-to-your-account-s)

### Responses and Results

- All the post requests are asynchronous apart from [TokenService](#tokenservice). This means that the result will be posted to your custom callback url when the request is complete. The immediate response of the post requests contain the `location` url of the request you have sent which you can use to query the status.

Note: The asynchronous results are processed like webhooks but use the application secret instead of the webhook secret.

- To access the different parts of the response or webhook payload passed, use the following keys to access:

  #### Webhooks

- Buygoods Received

  - `id`
  - `resourceId`
  - `topic`
  - `createdAt`
  - `eventType`
  - `reference`
  - `originationTime`
  - `senderMsisdn`
  - `amount`
  - `currency`
  - `tillNumber`
  - `system`
  - `status`
  - `firstName`
  - `middleName`
  - `lastName`
  - `linkSelf`
  - `linkResource`

- B2b transaction received

  - `id`
  - `resourceId`
  - `topic`
  - `createdAt`
  - `eventType`
  - `reference`
  - `originationTime`
  - `sendingTill`
  - `amount`
  - `currency`
  - `tillNumber`
  - `system`
  - `status`
  - `linkSelf`
  - `linkResource`

- Merchant to merchant transaction received

  - `id`
  - `resourceId`
  - `topic`
  - `createdAt`
  - `eventType`
  - `reference`
  - `originationTime`
  - `sendingMerchant`
  - `amount`
  - `currency`
  - `status`
  - `linkSelf`
  - `linkResource`

- Buygoods transaction reversed

  - `id`
  - `resourceId`
  - `topic`
  - `createdAt`
  - `eventType`
  - `reference`
  - `originationTime`
  - `reversalTime`
  - `senderMsisdn`
  - `amount`
  - `currency`
  - `tillNumber`
  - `system`
  - `status`
  - `firstName`
  - `middleName`
  - `lastName`
  - `linkSelf`
  - `linkResource`

- Transfer completed webhook

  - `id`
  - `resourceId`
  - `topic`
  - `createdAt`
  - `eventType`
  - `reference`
  - `originationTime`
  - `transferTime`
  - `transferType`
  - `amount`
  - `currency`
  - `status`
  - `linkSelf`
  - `linkResource`
  - `destinationType`
  - if destination type is bank:

    - `destinationMode`
    - `destinationBank`
    - `destinationBranch`
    - `destinationAccountNumber`

  - if destination type is mobile wallet:

    - `destinationMsisdn`
    - `destinationMmSystem`

- Customer created webhook

  - `id`
  - `resourceId`
  - `topic`
  - `createdAt`
  - `eventType`
  - `firstName`
  - `middleName`
  - `lastName`
  - `msisdn`
  - `linkSelf`
  - `linkResource`

- Transfer result

  - `id`
  - `type`
  - `status`
  - `transactionReference`
  - `destination`
  - `originationTime`
  - `initiationTime`
  - `amount`
  - `currency`
  - `metadata`
  - `linkSelf`
  - `callbackUrl`

- Pay result

  - `id`
  - `type`
  - `status`
  - `transactionReference`
  - `originationTime`
  - `initiationTime`
  - `destination`
  - `amount`
  - `currency`
  - `metadata`
  - `linkSelf`
  - `callbackUrl`

- Stk Push Result

  - Successful result

    - `id`
    - `type`
    - `initiationTime`
    - `status`
    - `eventType`
    - `transactionReference`
    - `originationTime`
    - `senderMsisdn`
    - `amount`
    - `currency`
    - `tillIdentifier`
    - `system`
    - `firstName`
    - `middleName`
    - `lastName`
    - `errors`
    - `metadata`
    - `linkSelf`
    - `callbackUrl`

  - Unsuccessful result

    - `id`
    - `type`
    - `initiationTime`
    - `status`
    - `eventType`
    - `resource`
    - `errorsCode`
    - `errorsDescription`
    - `metadata`
    - `linkSelf`
    - `callbackUrl`
#### Status payloads
-

For more information on the expected payloads and error codes, please read the [api docs](https://api-docs.kopokopo.com)

## Author

[Nicollet Njora](https://github.com/NicoNjora)

## Contributions

We welcome contributions with open arms just make a pull request and we will review.

### Development

Run all tests:

```bash
$ composer install
$ php vendor/bin/phpunit tests --testdox
```

### Issues

If you find a bug, please file an issue on [our issue tracker on GitHub](https://github.com/kopokopo/k2-connect-php/issues).

## License

k2-connect-php is MIT licensed. See [LICENSE](https://github.com/kopokopo/k2-connect-php/blob/master/LICENSE) for details.

## Change log
