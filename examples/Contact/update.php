<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Autoload files using Composer autoload

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\ContactService;

$owner = '*****@*****'; // Owner e-mail address
$email = '*****@*****'; // Contact e-mail address
$data = [
    'contact' => [
        'name' => 'John Ex',
        // ...
    ],
];

$clientId = '******';
$endPoint = '***.salesmanago.pl'; // ex. app3.salesmanago.pl
$apiSecret = '******';
$apiKey = '******';

try {
    $salesManagoClient = new Client($clientId, $endPoint, $apiSecret, $apiKey);
    $contactService = new ContactService($salesManagoClient);

    $response = $contactService->update($owner, $email, $data);
    var_dump($response);
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($e->getRequestData());
    var_dump($e->getResponseData());
}
