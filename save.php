<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imdb_id = $_POST['imdb_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $release_date = $_POST['release_date'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $poster_url = $_POST['poster_url'] ?? '';
    $user_note = $_POST['user_note'] ?? null;
    $user_comment = $_POST['user_comment'] ?? '';

    $sql = "INSERT INTO movies (imdb_id, title, release_date, rating, poster_url, user_note, user_comment) 
            VALUES (:imdb_id, :title, :release_date, :rating, :poster_url, :user_note, :user_comment)";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':imdb_id' => $imdb_id,
        ':title' => $title,
        ':release_date' => $release_date,
        ':rating' => $rating,
        ':poster_url' => $poster_url,
        ':user_note' => $user_note,
        ':user_comment' => $user_comment
    ]);

    header('Location: index.php?success=1');
    exit;
}
?>