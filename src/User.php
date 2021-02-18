<?php


class User {

    public $attributes;

    public function __construct(array $attributes) 
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public static function create(array $attributes) : ?User
    {
        $pdo = User::connect();
        $stmt = $pdo->prepare('INSERT INTO users(email, name, password) VALUES(:email, :name, :password)');
        $stmt->bindValue(':email', $attributes['email']);
        $stmt->bindValue(':name', $attributes['name']);
        $stmt->bindValue(':password', $attributes['password']);
        if($stmt->execute()){
            return User::find($pdo->lastInsertId('id'));
        }
        return null;

    }

    public static function find($id) : ?User
    {
        $stmt = User::connect()->prepare('SELECT id, email, name FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $attrs = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($attrs);
    }

    public static function connect(): PDO
    {
        $pdo = new PDO('mysql:dbname=app-database;host=db;charset=utf8mb4', 'test', 'secret');

        return $pdo;
    }
}