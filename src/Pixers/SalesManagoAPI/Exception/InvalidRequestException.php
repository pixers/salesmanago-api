<?php

namespace Pixers\SalesManagoAPI\Exception;

use GuzzleHttp\Psr7\Response as Response;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class InvalidRequestException extends SalesManagoAPIException
{
    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var string
     */
    protected $requestUrl;

    /**
     * @var array
     */
    protected $requestData;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Extended Exception constructor.
     *
     * @param string   $requestMethod Request method
     * @param string   $requestUrl    Request URL
     * @param array    $requestData   Request data
     * @param Response $response      Response
     */
    public function __construct($requestMethod, $requestUrl, array $requestData, Response $response)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUrl = $requestUrl;
        $this->requestData = $requestData;
        $this->response = $response;
        $this->message = 'Error occured when sending request.';

        parent::__construct($this->message, 0, null);
    }

    /**
     * Returning request method.
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * Returning request url.
     *
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * Returning request data.
     *
     * @return array
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * Returning response.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
