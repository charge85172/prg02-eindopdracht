<?php

// Validate and sanitize the id parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid ID provided.');
}
/** @var $db */
require_once "connection.php";
$id = mysqli_escape_string($db, $_GET['id']);

$query = "SELECT * FROM artists WHERE id = $id";
$result = mysqli_query($db, $query);
// Fetch the album data

if ($row = mysqli_fetch_assoc($result)) {
    $artist = $row;
} else {
    die('ID does not exist');
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Music Collection - Details <?= htmlentities($artist['name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<header class="hero is-info">
    <div class="hero-body">
        <p class="title">Music Collection</p>
        <p class="subtitle"><?= htmlentities($artist['name']) ?></p>
    </div>
</header>

<main class="container">
    <section class="section content">
        <ul>
            <li>Genre: <?= htmlentities($artist['genre']) ?></li>
            <li>Albums: <?= htmlentities($artist['albumcount']) ?></li>
        </ul>
        <a class="button" href="index.php">Go back to the list</a>
    </section>
</main>
</body>
</html>