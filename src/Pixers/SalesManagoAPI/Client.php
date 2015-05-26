<?php

namespace Pixers\SalesManagoAPI;

use Pixers\SalesManagoAPI\Exception\InvalidRequestException;
use Pixers\SalesManagoAPI\Exception\InvalidArgumentException;

/**
 * SalesManago API implementation.
 *
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class Client
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var CurlClient
     */
    protected $curlClient;

    /**
     * Initialization.
     */
    public function __construct($clientId, $endPoint, $apiSecret, $apiKey)
    {
        $this->config = [
            'client_id' => $clientId,
            'endpoint' => $endPoint,
            'api_secret' => $apiSecret,
            'api_key' => $apiKey,
        ];

        foreach ($this->config as $key => $parameter) {
            if (empty($parameter)) {
                throw new InvalidArgumentException($key.' parameter is required', $parameter);
            }
        }

        $this->curlClient = new CurlClient();
    }

    /**
     * Send POST request to SalesManago API.
     *
     * @param string $method API Method
     * @param array  $data   Request data
     *
     * @return array
     */
    public function doPost($method, array $data)
    {
        return $this->doRequest(CurlClient::METHOD_POST, $method, $data);
    }

    /**
     * Send GET request to SalesManago API.
     *
     * @param string $method API Method
     * @param array  $data   Request data
     *
     * @return array
     */
    public function doGet($method, array $data)
    {
        return $this->doRequest(CurlClient::METHOD_GET, $method, $data);
    }

    /**
     * Send request to SalesManago API.
     *
     * @param string $method    HTTP Method
     * @param string $apiMethod API Method
     * @param array  $data      Request data
     *
     * @return array
     */
    protected function doRequest($method, $apiMethod, array $data)
    {
        $url = 'http://'.$this->config['endpoint'].'/api/'.$apiMethod;
        $data = array_merge($this->createAuthData(), $data);

        $response = $this->curlClient->doRequest($method, $url, $data);

        if (!isset($response['success']) || !$response['success']) {
            throw new InvalidRequestException($method, $url, $data, $response);
        }

        return $response;
    }

    /**
     * Returns an array of authentication data.
     *
     * @return array
     */
    protected function createAuthData()
    {
        return [
            'clientId' => $this->config['client_id'],
            'apiKey' => $this->config['api_key'],
            'requestTime' => time(),
            'sha' => sha1($this->config['api_key'].$this->config['client_id'].$this->config['api_secret']),
        ];
    }
}
