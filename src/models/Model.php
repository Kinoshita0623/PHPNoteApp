<?php

class Model {
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        return $this->attributes[$key] = $value;
    }

    public static function connect(): PDO
    {
        $pdo = new PDO('mysql:dbname=app-database;host=db;charset=utf8mb4', 'test', 'secret');

        return $pdo;
    }
}
?>