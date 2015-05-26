<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Autoload files using Composer autoload

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\TagService;

$owner = '*****@*****'; // Owner e-mail address
$data = [
    'showSystemTags' => true,
];

$clientId = '******';
$endPoint = '***.salesmanago.pl'; // ex. app3.salesmanago.pl
$apiSecret = '******';
$apiKey = '******';

try {
    $salesManagoClient = new Client($clientId, $endPoint, $apiSecret, $apiKey);
    $tagService = new TagService($salesManagoClient);

    $response = $tagService->getAll($owner, $data);
    var_dump($response);
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($e->getRequestData());
    var_dump($e->getResponseData());
}
