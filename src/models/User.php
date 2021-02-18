<?php
require_once('Model.php');
require_once('Note.php');


class User extends Model{

   

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
        $stmt = User::connect()->prepare('SELECT id, email, password, name FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $attrs = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($attrs);
    }

    public static function findByEmail($email) : ?User
    {
        $pdo = User::connect();
        $stmt = $pdo->prepare('SELECT id, email, name, password FROM users WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $attrs = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($attrs);
        
    }

    public function notes() : array
    {
        return Note::findByUserId($this->id);
    }

    public function createNote($attrs) : Note
    {
        return Note::create($this, $attrs);
    }

}