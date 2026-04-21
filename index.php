<?php
include 'includes/header.php';
require_once 'config.php';

$sql = "SELECT * FROM movies ORDER BY id DESC";
$stmt = $pdo->query($sql);
$movies = $stmt->fetchAll();

if (isset($_GET['success'])) {
    echo "<div class='alert alert-success'>Film enregistré avec succès dans votre collection !</div>";
}

echo "<h1 class='mb-4'>Ma Collection de Films</h1>";

if (count($movies) > 0) {
    echo "<div class='row'>";
    foreach ($movies as $movie) {
        echo "<div class='col-md-3 mb-4'>";
            echo "<div class='card h-100 shadow-sm'>";
                echo "<img src='" . htmlspecialchars($movie['poster_url']) . "' class='card-img-top' alt='Poster'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($movie['title']) . "</h5>";
                    echo "<p class='card-text text-muted'>" . htmlspecialchars($movie['release_date']) . "</p>";
                    echo "<a href='details.php?id=" . htmlspecialchars($movie['imdb_id']) . "' class='btn btn-primary btn-sm'>Voir la fiche</a>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p class='alert alert-info'>Votre collection est vide pour le moment.</p>";
}

include 'includes/footer.php';
?>