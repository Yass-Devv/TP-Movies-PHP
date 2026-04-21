<?php
include 'includes/header.php';

$query = $_GET['q'] ?? null;

if ($query) {
    $search_term = strtolower(trim($query));
    $search_term = str_replace(' ', '_', $search_term);
    $filename = "data/search_" . $search_term . ".html";

    if (file_exists($filename)) {
        $html = file_get_contents($filename);

        preg_match_all('/href="\/title\/(tt\d+)\/.*?".*?>(.*?)<\/a>/i', $html, $matches);

        echo "<h2>Résultats pour : " . htmlspecialchars($query) . "</h2>";
        echo "<div class='list-group mt-4 shadow-sm'>";
        
        $results = [];
        if (!empty($matches[1])) {
            foreach ($matches[1] as $index => $imdb_id) {
                $title = trim(strip_tags($matches[2][$index]));
                if (!empty($title) && !isset($results[$imdb_id])) {
                    $results[$imdb_id] = $title;
                }
            }
        }

        if (!empty($results)) {
            foreach ($results as $imdb_id => $title) {
                echo "<a href='details.php?id=$imdb_id' class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>";
                echo "<span>🎬 " . htmlspecialchars($title) . "</span>";
                echo "<span class='badge bg-primary rounded-pill'>Voir la fiche</span>";
                echo "</a>";
            }
        } else {
            echo "<p class='alert alert-warning'>Le fichier a été trouvé mais aucune donnée n'a pu être extraite.</p>";
        }
        echo "</div>";

    } else {
        echo "<div class='alert alert-danger'>Fichier <code>$filename</code> introuvable.</div>";
    }
}

include 'includes/footer.php';
?>