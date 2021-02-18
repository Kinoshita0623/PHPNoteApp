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
    }

    public static function find($id): ?Note
    {
        $pdo = Note::connect();
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $stmt->bindValue(':id', $id);
        
        $stmt->execute();
        return Note($stmt->fetch(PDO::FETCH_ASSOC));
        
    }

    public static function findByUserId($userId): array
    {
        $pdo = Note::connect();
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE user_id = :userId', [ PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL ]);
        $stmt->bindValue(':userId', $userId);

        $notes = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ntoes[] = new Note($row);
        }

        return $notes;
    }
}
?>