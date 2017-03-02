<?php

namespace Pixers\SalesManagoAPI;

use GuzzleHttp\Client as GuzzleClient;
use Pixers\SalesManagoAPI\Exception\InvalidRequestException;
use Pixers\SalesManagoAPI\Exception\InvalidArgumentException;

/**
 * SalesManago API implementation.
 *
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 * @author Michał Kanak <michal.kanak@pixers.pl>
 */
class Client
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /**
     * @var array
     */
    protected $config;

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * Initialization.
     *
     * @param string $clientId
     * @param string $endPoint
     * @param string $apiSecret
     * @param string $apiKey Basically a random string
     *
     * @throws \Pixers\SalesManagoAPI\Exception\InvalidArgumentException
     */
    public function __construct($clientId, $endPoint, $apiSecret, $apiKey)
    {
        $this->config = [
          'client_id' => $clientId,
          'endpoint' => rtrim($endPoint, '/') . '/',
          'api_secret' => $apiSecret,
          'api_key' => $apiKey
        ];

        foreach ($this->config as $key => $parameter) {
            if (empty($parameter)) {
                throw new InvalidArgumentException($key . ' parameter is required', $parameter);
            }
        }
    }

    /**
     * Sets GuzzleClient.
     *
     * @param GuzzleClient $guzzleClient
     */
    public function setGuzzleClient(GuzzleClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Gets GuzzleClient.
     *
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        if (!$this->guzzleClient) {
            $this->guzzleClient = new GuzzleClient();
        }

        return $this->guzzleClient;
    }

    /**
     * Send POST request to SalesManago API.
     *
     * @param  string $method API Method
     * @param  array  $data   Request data
     * @return array
     */
    public function doPost($method, array $data)
    {
        return $this->doRequest(self::METHOD_POST, $method, $data);
    }

    /**
     * Send GET request to SalesManago API.
     *
     * @param  string $method API Method
     * @param  array  $data   Request data
     * @return array
     */
    public function doGet($method, array $data)
    {
        return $this->doRequest(self::METHOD_GET, $method, $data);
    }

    /**
     * Send request to SalesManago API.
     *
     * @param  string $method    HTTP Method
     * @param  string $apiMethod API Method
     * @param  array  $data      Request data
     *
     * @return array
     * @throws \Pixers\SalesManagoAPI\Exception\InvalidRequestException
     */
    protected function doRequest($method, $apiMethod, array $data = [])
    {
        $url = $this->config['endpoint'] . $apiMethod;
        $data = $this->mergeData($this->createAuthData(), $data);

        $response = $this->getGuzzleClient()->request($method, $url, ['json' => $data]);
        $responseContent = \GuzzleHttp\json_decode($response->getBody());

        if (!property_exists($responseContent, 'success') || !$responseContent->success) {
            throw new InvalidRequestException($method, $url, $data, $response);
        }

        return $responseContent;
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
          'sha' => sha1($this->config['api_key'] . $this->config['client_id'] . $this->config['api_secret'])
        ];
    }

    /**
     * Merge data and removing null values.
     *
     * @param  array $base         The array in which elements are replaced
     * @param  array $replacements The array from which elements will be extracted
     * @return array
     */
    private function mergeData(array $base, array $replacements)
    {
        return array_filter(array_merge($base, $replacements), function($value) {
            return $value !== null;
        });
    }
}
