<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Autoload files using Composer autoload

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\EventService;

$owner = '*****@*****'; // Owner e-mail address
$eventId = '************'; // SalesManago internal event ID
$data = [
    'contactEvent' => [
        'detail1' => 'Some event detail with new data',
        'date' => date('c', time()),
    ],
    // ...
];

$clientId = '******';
$endPoint = '***.salesmanago.pl'; // ex. app3.salesmanago.pl
$apiSecret = '******';
$apiKey = '******';

try {
    $salesManagoClient = new Client($clientId, $endPoint, $apiSecret, $apiKey);
    $eventService = new EventService($salesManagoClient);

    $response = $eventService->update($owner, $eventId, $data);
    var_dump($response);
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($e->getRequestData());
    var_dump($e->getResponseData());
}
