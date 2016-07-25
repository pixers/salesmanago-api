<?php

use PHPUnit\Framework\TestCase;
use Pixers\SalesManagoAPI\Client;

class ClientTest extends TestCase
{
     /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function shouldFailedWhileCreatingClientWithoutAnyData()
    {
        $client = new Client();
    }

    /**
     * @test
     */
    public function shouldPassedWhileCreatingClientWithData()
    {
        $clientId = 'test';
        $endPoint = 'test';
        $apiSecret = 'test'; 
        $apiKey = 'test';
    
        $client = new Client($clientId, $endPoint, $apiSecret, $apiKey);
    }
}
