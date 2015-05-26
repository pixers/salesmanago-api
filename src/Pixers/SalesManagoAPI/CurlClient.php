<?php

namespace Pixers\SalesManagoAPI;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class CurlClient
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    /**
     * Send request.
     *
     * @param array  $method Method
     * @param string $url    URL
     * @param array  $data   Data
     *
     * @return array
     */
    public function doRequest($method, $url, array $data)
    {
        if ($method === self::METHOD_GET) {
            $url  .= '?'.http_build_query($data);
        }

        $ch = curl_init($url);

        if ($method === self::METHOD_POST) {
            $data = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                'Accept: application/json, application/json',
                'Content-Type: application/json;charset=UTF-8',
            ]
        );

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
