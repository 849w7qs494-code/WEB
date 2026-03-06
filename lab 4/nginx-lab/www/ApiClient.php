<?php
require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

class ApiClient {
    private Client $client;

    public function __construct() {
        // Создаём HTTP-клиент
        $this->client = new Client([
            'timeout' => 10.0,
            'verify' => false
        ]);
    }

    public function request(string $url): array {
        try {
            $response = $this->client->get($url);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getAreas(): array {
        return $this->request('https://api.hh.ru/areas');
    }

    public function getCountriesList(): array {
        $areas = $this->getAreas();
        $countries = [];
        
        if (!isset($areas['error'])) {
            foreach ($areas as $country) {
                $countries[$country['id']] = $country['name'];
            }
        }
        
        return $countries;
    }

    public function getCitiesByCountryId(string $countryId): array {
        $areas = $this->getAreas();
        $cities = [];
        
        if (!isset($areas['error'])) {
            foreach ($areas as $country) {
                if ($country['id'] == $countryId) {
                    foreach ($country['areas'] as $area) {
                        $cities[$area['id']] = $area['name'];
                    }
                    break;
                }
            }
        }
        
        return $cities;
    }
}