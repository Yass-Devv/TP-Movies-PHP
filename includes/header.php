<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>My Movies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">🎬 My Movies</a>
        <form class="d-flex" action="search.php" method="GET">
            <input class="form-control me-2" type="search" name="q" placeholder="Rechercher un film...">
            <button class="btn btn-outline-success" type="submit">Go</button>
        </form>
    </div>
</nav>
<div class="container">