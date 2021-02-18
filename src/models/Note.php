<?php
require_once('Model.php');
require_once('User.php');

class Note extends Model{


    public static function create(User $user, array $attrs): ?Note
    {
        $pdo = Note::connect();
        $stmt = $pdo->prepare('INSERT INTO notes(title, text, user_id) VALUES(:title, :text, :user_id)');
        $stmt->bindValue(':title', $attrs['title']);
        $stmt->bindValue(':text', $attrs['text']);
        $stmt->bindValue(':user_id', $user->id);
        if($stmt->execute()){
            return Note::find($pdo->lastInsertId('id'));
        }

        return null;
    }

    public static function find($id): ?Note
    {
        $pdo = Note::connect();
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $stmt->bindValue(':id', $id);
        
        $stmt->execute();
        return new Note($stmt->fetch(PDO::FETCH_ASSOC));
        
    }

    public static function findByUserId($userId): array
    {
        $pdo = Note::connect();
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE user_id = :userId');
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $notes = [];
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(is_array($results)) {
            foreach($results as $row){
                array_push($notes, new Note($row));
            }
        }
        
        return $notes;
    }
}
?>