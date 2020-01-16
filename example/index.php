<?php

require 'vendor/autoload.php';

use Kopokopo\SDK\K2;

$K2_CLIENT_ID = 'onDPKB6ZY_KT4hrUnsWJEuCXW3VvGHnI_XZv5dmsxPQ';
$K2_CLIENT_SECRET = 'A1Wqj1_9KKAn1oAa3G9eCkqXwzM0GT9BgEMsjiXq0Zc';
$BASE_URL = 'http://localhost:3000';

$K2 = new K2($K2_CLIENT_ID, $K2_CLIENT_SECRET, $BASE_URL);

$router = new AltoRouter();

$tokens = $K2->TokenService();
$response = $tokens->getToken();

$access_token = $response['access_token'];

// map homepage
$router->map('GET', '/', function () {
    require __DIR__.'/views/index.php';
});

$router->map('GET', '/webhook/subscribe', function () {
    require __DIR__.'/views/subscribe.php';
});

$router->map('GET', '/stk', function () {
    require __DIR__.'/views/receive.php';
});

$router->map('GET', '/stk/status', function () {
    require __DIR__.'/views/stkstatus.php';
});

$router->map('GET', '/transfer', function () {
    require __DIR__.'/views/transfer.php';
});

$router->map('GET', '/transfer/status', function () {
    require __DIR__.'/views/transferstatus.php';
});

$router->map('GET', '/pay', function () {
    require __DIR__.'/views/pay.php';
});

$router->map('GET', '/pay/status', function () {
    require __DIR__.'/views/paystatus.php';
});

$router->map('POST', '/webhook/subscribe', function () {
    global $K2;

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $strju = json_encode($response['data'], true);
    echo $strju;

    $access_token = $response['data']['access_token'];

    echo $access_token;

    $webhooks = $K2->Webhooks();

    $options = array(
        'eventType' => $_POST['event_type'],
        'url' => $_POST['url'],
        'webhookSecret' => 'my_webhook_secret',
        'accessToken' => $access_token,
    );
    $response = $webhooks->subscribe($options);

    // return view("views/response.php",compact('response'));
});

$router->map('POST', '/stk', function () {
    global $K2;
    $stk = $K2->StkService();

    $options = [
        'paymentChannel' => 'M-PESA',
        'tillNumber' => '13432',
        'firstName' => $_POST['first_name'],
        'lastName' => $_POST['last_name'],
        'phone' => $_POST['phone'],
        'amount' => $_POST['amount'],
        'currency' => 'KES',
        'email' => 'example@example.com',
        'callbackUrl' => 'http://localhost:8000/test',
        'accessToken' => 'suE2FwMpDM5c_j2EKuL-9Y2gzj9F73NOukVUy6Lx5B8',
    ];
    $response = $stk->paymentRequest($options);

    return view("views/response.php",compact('response'));
});

$router->map('POST', '/transfer', function () {
    global $K2;
    $transfer = $K2->TransferService();

    $options = [
        'amount' => $_POST['amount'],
        'currency' => 'KES',
        'destination' => $_POST['destination'],
        'accessToken' => 'myRand0mAcc3ssT0k3n',
    ];
    $response = $transfer->settleFunds($options);

    return view("views/response.php",compact('response'));
});

$router->map('POST', '/pay', function () {
    global $K2;

    // $tokens = $K2->TokenService();
    // $tk = $tokens->getToken();
    // echo json_encode($tk);
    // $access_token = $tk['data']['access_token'];
    // echo $access_token;
    // // global $K2;
    $pay = $K2->PayService();

    $options = [
        'destination' => $_POST['destination'],
        'amount' => $_POST['amount'],
        'currency' => 'KES',
        'accessToken' => "9ndnmYsLhomlsTBibGBdmObUVKwU48ICmq6lJkl0hUc",
        'callbackUrl' => 'http://localhost:8000/webhook',
    ];
    $response = $pay->sendPay($options);

    return view("views/response.php",compact('response'));
});

$router->map('POST', '/webhook', function () {
    global $K2;
    global $response;

    $webhooks = $K2->Webhooks();

    $json_str = file_get_contents('php://input');

    $response = $webhooks->webhookHandler($json_str, $_SERVER['HTTP_X_KOPOKOPO_SIGNATURE']);

    // echo json_encode($response);
    return view("views/response.php",compact('response'));
    // print("POST Details: " .$json_str);
    // print_r($json_str);
});

$router->map('GET', '/webhook/resource', function () {
    global $response;
    echo $response;
    echo $response;
});

function view($page,$variables=[]) {
    if(count($variables)) {
        extract($variables);
    }
    require $page;
}

$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
}
