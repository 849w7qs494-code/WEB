<?php
require_once __DIR__ . '/Helpers/ClientFactory.php';

class ElasticExample
{
    private $client;

    public function __construct()
    {
        $this->client = ClientFactory::make('http://elasticsearch:9200/');
    }

    public function indexDocument($index, $id, $data)
    {
        $response = $this->client->put("$index/_doc/$id", [
            'json' => $data
        ]);
        return json_decode($response->getBody(), true);
    }

    public function search($index, $query)
    {
        $response = $this->client->post("$index/_search", [
            'json' => ['query' => ['match' => $query]]
        ]);
        return json_decode($response->getBody(), true);
    }

    public function deleteIndex($index)
    {
        $response = $this->client->delete($index);
        return json_decode($response->getBody(), true);
    }
}