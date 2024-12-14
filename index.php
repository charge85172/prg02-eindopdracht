<?php
session_start();
/** @var mysqli $db */
require_once 'connection.php';
$query = "SELECT * FROM artists";
$result = mysqli_query($db, $query) or die("ERROR");

$artists = [];
while ($row = mysqli_fetch_assoc($result)) {
    $artists[] = $row;
}

mysqli_close($db);
?>

<!doctype html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Music Collection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<header class="hero is-info">
    <div class="hero-body">
        <p class="title">Charge's Favourite Artists</p>
        <p class="subtitle">Overview of the artists</p>
    </div>
</header>

<div class="is-fixed-top is-right">
    <a class="button" href="logout.php">Uitloggen</a>
    <a class="button" href="login.php">Inloggen</a>
    <a class="button" href="register.php">Registreren</a>
</div>

<main class="container">
    <section class="section">
        <table class="table mx-auto">
            <thead>
            <tr>
                <th>Position</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Albums</th>
                <th><a href="create.php">Create new+</a></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($artists

            as $index => $artist) { ?>
            <tr>
                <td> <?= $index + 1; ?></td>
                <td> <?= $artist['name']; ?></td>
                <td> <?= $artist['genre']; ?></td>
                <td> <?= $artist['albumcount']; ?></td>
                <td><a href="detail.php?id=<?= $artist['id'] ?>">Details</a></td>
                <td><a href="edit.php?id=<?= $artist['id'] ?>">Aanpassen</a></td>

                <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">&copy; My Favourite Artists.</td>
            </tr>
            </tfoot>
        </table>
    </section>
</main>
</body>
</html>