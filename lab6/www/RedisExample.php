<?php
use Predis\Client;

class RedisExample
{
    private $client;

    public function __construct()
    {
        $this->client = new Client('tcp://redis:6379');
    }

    public function createUser($userId, $userData)
    {
        return $this->client->hmset("user:$userId", $userData);
    }

    public function getUser($userId)
    {
        return $this->client->hgetall("user:$userId");
    }

    public function updateUser($userId, $field, $value)
    {
        return $this->client->hset("user:$userId", $field, $value);
    }

    public function deleteUser($userId)
    {
        return $this->client->del("user:$userId");
    }

    public function deleteAllUsers()
    {
        $keys = $this->client->keys('user:*');
        foreach ($keys as $key) {
            $this->client->del($key);
        }
        return count($keys);
    }

    public function getAllUsers()
    {
        $keys = $this->client->keys('user:*');
        $users = [];
        foreach ($keys as $key) {
            $id = str_replace('user:', '', $key);
            $users[$id] = $this->getUser($id);
        }
        return $users;
    }

    public function setValue($key, $value)
    {
        return $this->client->set($key, $value);
    }

    public function getValue($key)
    {
        return $this->client->get($key);
    }
}