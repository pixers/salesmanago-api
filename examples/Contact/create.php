<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Autoload files using Composer autoload

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\ContactService;

$owner = 'sylwester.luczak@pixers.pl'; // Owner e-mail address
$data = [
    'contact' => [
        'company' => 'Some company name',
        'email' => 'john.ex@example.com',
        'fax' => '987654321',
        'name' => 'John Ex',
        'phone' => '123456789',
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

    $response = $contactService->create($owner, $data);
    var_dump($response);
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($e->getRequestData());
    var_dump($e->getResponseData());
}
