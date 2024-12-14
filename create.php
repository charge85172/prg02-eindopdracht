<?php
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $album = $_POST['albumcount'];

    $errors = [];
    if ($name == '') {
        $errors['name'] = "De naam is verplicht.";
    }
    if ($genre == '') {
        $errors['genre'] = "Het genre is verplicht.";
    }
    if ($album == '') {
        $errors['albumcount'] = "Het aantal albums is verplicht.";
    } elseif (!is_numeric($album)) {
        $errors['albumcount'] = "Het aantal albums moet een getal zijn.";
    }

    require_once('connection.php');
    /** @var $db */

    if (empty($errors)) {
        $query = "INSERT INTO `artists`(`name`, `genre`, `albumcount`) VALUES ('$name','$genre','$album')";
        $result = mysqli_query($db, $query)
        or die('Error '.mysqli_error($db).' with query '.$query);


        header('location: index.php');
        mysqli_close($db);
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Muziekalbums - Create</title>
</head>
<body>
<div class="container px-5">
    <section class="columns is-centered">
        <div class="column is-11">
            <h2 class="title mt-4">Edit artist</h2>

            <form class="column is-10" action="" method="post">

                <div class="field">
                    <label class="label" for="name">Name</label>
                    <div class="control">
                        <input class="input" id="name" type="text" name="name"
                               value="<?= htmlentities($name ?? '') ?>"/>
                    </div>
                    <p class="help is-danger">
                        <?= $errors['name'] ?? '' ?>
                    </p>
                </div>

                <div class="field">
                    <label class="label" for="genre">Genre</label>
                    <div class="control">
                        <input class="input" id="genre" type="text" name="genre"
                               value="<?= htmlentities($genre ?? '') ?>"/>
                    </div>
                    <p class="help is-danger">
                        <?= $errors['genre'] ?? '' ?>
                    </p>
                </div>
                <div class="field">
                    <label class="label" for="albumcount">Albums</label>
                    <div class="control">
                        <input class="input" id="albumcount" type="text" name="albumcount"
                               value="<?= htmlentities($album ?? '') ?>"/>
                    </div>
                    <p class="help is-danger">
                        <?= $errors['albumcount'] ?? '' ?>
                    </p>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
                    </div>
                </div>

            </form>

            <a class="button mt-4" href="index.php">&laquo;
            </a>
        </div>
    </section>
</div>
</body>
</html>
