<?php
include 'includes/header.php';
require_once 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE imdb_id = :id");
    $stmt->execute([':id' => $id]);
    $movie = $stmt->fetch();

    if ($movie) {
        $title = $movie['title'];
        $date = $movie['release_date'];
        $rating = $movie['rating'];
        $poster_url = $movie['poster_url'];
        $user_note = $movie['user_note'];
        $user_comment = $movie['user_comment'];
        $source = "Base de données";
    } else {
        $filename = "data/" . $id . ".html";
        if (file_exists($filename)) {
            $html = file_get_contents($filename);
            preg_match('/<h1.*?>(.*?)<\/h1>/is', $html, $match_title);
            $title = isset($match_title[1]) ? strip_tags($match_title[1]) : "Titre inconnu";
            preg_match('/<div class="ipc-media.*?<img.*?src="(.*?)"/is', $html, $match_poster);
            $poster_url = $match_poster[1] ?? "https://via.placeholder.com/300x450";
            preg_match('/"aggregateRating":(\d+\.\d+|\d+)/', $html, $match_rating);
            $rating = $match_rating[1] ?? "N/A";
            preg_match('/(\d{4})/', $html, $match_date);
            $date = $match_date[1] ?? "Date inconnue";
            $user_note = null;
            $user_comment = "";
            $source = "Fichier IMDb";
        } else {
            die("Film introuvable.");
        }
    }

    echo "<div class='card shadow-sm p-4'>";
    echo "<span class='badge bg-info mb-2'>Source : $source</span>";
    echo "<div class='row'>";
        echo "<div class='col-md-4'><img src='$poster_url' class='img-fluid rounded shadow'></div>";
        echo "<div class='col-md-8'>";
            echo "<h1 class='display-5 text-primary'>$title</h1>";
            echo "<p class='lead'>Année : $date</p>";
            echo "<div class='alert alert-warning d-inline-block'>⭐ Note IMDb : $rating / 10</div>";
            
            if ($movie) {
                echo "<div class='mt-3 p-3 bg-light border rounded'>";
                echo "<h4>Mon avis enregistré :</h4>";
                echo "<p><strong>Ma note :</strong> $user_note / 10</p>";
                echo "<p><strong>Mon commentaire :</strong> $user_comment</p>";
                echo "</div>";
            }
        echo "</div>";
    echo "</div>";

    if (!$movie) {
        echo "<hr><h3>Ajouter mon avis</h3>
              <form action='save.php' method='POST'>
                <input type='hidden' name='imdb_id' value='$id'>
                <input type='hidden' name='title' value='" . htmlspecialchars($title) . "'>
                <input type='hidden' name='release_date' value='$date'>
                <input type='hidden' name='rating' value='$rating'>
                <input type='hidden' name='poster_url' value='$poster_url'>
                <div class='mb-3'><label class='form-label'>Ma note /10</label>
                <input type='number' name='user_note' class='form-control' max='10'></div>
                <div class='mb-3'><label class='form-label'>Mon commentaire</label>
                <textarea name='user_comment' class='form-control' rows='3'></textarea></div>
                <button type='submit' class='btn btn-success'>Enregistrer</button>
              </form>";
    }
    echo "</div>";
}
include 'includes/footer.php';
?>