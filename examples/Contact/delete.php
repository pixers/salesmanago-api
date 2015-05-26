<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Autoload files using Composer autoload

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\ContactService;

$owner = '*****@*****'; // Owner e-mail address
$email = '*****@*****'; // Contact e-mail address
$data = [
    'permanently' => true, // Delete permanently or just disable and hide
];

$clientId = '******';
$endPoint = '***.salesmanago.pl'; // ex. app3.salesmanago.pl
$apiSecret = '******';
$apiKey = '******';

try {
    $salesManagoClient = new Client($clientId, $endPoint, $apiSecret, $apiKey);
    $contactService = new ContactService($salesManagoClient);

    $response = $contactService->delete($owner, $email, $data);
    var_dump($response);
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($e->getRequestData());
    var_dump($e->getResponseData());
}
