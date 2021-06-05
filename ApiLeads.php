<?php

namespace app;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use http\Exception\RuntimeException;

class ApiLeads {

    private $token;
    private $client;

    private const BASE_API_URL = 'http://api.leads.su/webmaster/';


    public function __construct(string $token, Client $client)
    {
        $this->token = $token;
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getAccountInfo(): string
    {
        $url = self::BASE_API_URL . 'account';
        $result =  $this->request($url);
        return 'ID: ' . $result['id'] . PHP_EOL . 'Имя пользователя: ' . $result['name'];
    }


    /**
     * @return string
     */
    public function getCountry(): string
    {
        $url = self::BASE_API_URL . 'geo/getCountries';
        $countryNames = array_column($this->request($url), 'name');
        $result =  array_slice(array_reverse($countryNames), 0, 10);
        return implode(PHP_EOL, $result);
    }


    /**
     * @param $url
     * @return mixed
     */
    private function request($url): array
    {
        $client = $this->client;
        try {
            $response = $client->post($url . '?token=' . $this->token);
        } catch (GuzzleException $e) {
            throw new RuntimeException('Error', $e->getCode(), $e);
        }

        if($response->getStatusCode() !== 200) {
            throw new RuntimeException('Error');
        }

        return json_decode($response->getBody(), true)['data'];
    }
}