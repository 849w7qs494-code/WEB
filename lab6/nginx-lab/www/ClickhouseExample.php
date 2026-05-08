<?php
require_once __DIR__ . '/Helpers/ClientFactory.php';

class ClickhouseExample
{
    private $client;

    public function __construct()
    {
        $this->client = ClientFactory::make('http://clickhouse:8123/');
    }

    public function query($sql)
    {
        $response = $this->client->post('', [
            'body' => $sql,
            'headers' => ['Content-Type' => 'text/plain']
        ]);
        return $response->getBody()->getContents();
    }

    public function insert($table, $data)
    {
        if (empty($data)) return '';
        
        $columns = implode(',', array_keys($data[0]));
        $values = [];
        foreach ($data as $row) {
            $rowValues = array_map(function($val) {
                return is_numeric($val) ? $val : "'$val'";
            }, array_values($row));
            $values[] = '(' . implode(',', $rowValues) . ')';
        }
        $sql = "INSERT INTO $table ($columns) VALUES " . implode(',', $values);
        return $this->query($sql);
    }
}