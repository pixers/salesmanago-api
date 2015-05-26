<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Autoload files using Composer autoload

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\ContactService;

$data = [
    'from' => date('c', strtotime('-1 day', time())),
    'to' => date('c', time()),
    'allVisits' => true,
];

$clientId = '******';
$endPoint = '***.salesmanago.pl'; // ex. app3.salesmanago.pl
$apiSecret = '******';
$apiKey = '******';

try {
    $salesManagoClient = new Client($clientId, $endPoint, $apiSecret, $apiKey);
    $contactService = new ContactService($salesManagoClient);

    $response = $contactService->listRecentActivity($data);
    var_dump($response);
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($e->getRequestData());
    var_dump($e->getResponseData());
}
