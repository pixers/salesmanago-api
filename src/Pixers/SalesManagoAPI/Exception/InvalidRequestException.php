<?php

namespace Pixers\SalesManagoAPI\Exception;

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
     * @var array
     */
    protected $responseData;

    /**
     * Extended Exception constructor.
     *
     * @param string $requestMethod Request method
     * @param string $requestUrl    Request URL
     * @param array  $requestData   Request data
     * @param array  $responseData  Response data
     */
    public function __construct($requestMethod, $requestUrl, array $requestData, array $responseData = null)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUrl = $requestUrl;
        $this->requestData = $requestData;
        $this->responseData = $responseData;
        $this->message = 'Error occured when sending request.';

        parent::__construct($message, 0, null);
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
     * Returning response data.
     *
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }
}
