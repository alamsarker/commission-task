<?php

declare(strict_types=1);

namespace App\HttpClient;

final class HttpClient
{
    /**
     * Calling Api
     */
    public function sendRequest($method, $url)
    {
        $curlHanlder = curl_init();

        curl_setopt($curlHanlder, CURLOPT_URL, $url);
        curl_setopt($curlHanlder, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curlHanlder);
        curl_close($curlHanlder);

        return json_decode($response, true);
    }
}
