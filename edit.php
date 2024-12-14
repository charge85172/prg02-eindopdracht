<?php
// Check if the 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    die("ID parameter is missing.");
}

require_once "connection.php";
/** @var  $db */
$id = mysqli_escape_string($db, $_GET['id']);


// Prepare and execute the SELECT query to fetch the artist's current data
$query = "SELECT * FROM artists WHERE id = $id";
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);


// Fetch the artist's data
$artist = $result->fetch_assoc();
if (!$artist) {
    die("Artist not found.");
}

// Initialize variables for form data and errors
$name = $artist['name'];
$genre = $artist['genre'];
$album = $artist['albumcount'];
$errors = [];

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $album = $_POST['albumcount'];

    // Validate form data
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

    // If there are no errors, proceed to update the artist's information
    if (empty($errors)) {
        $query = "UPDATE `artists` SET `name` = ?, `genre` = ?, `albumcount` = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssii", $name, $genre, $album, $id);
        if ($stmt->execute()) {
            // Close the database connection
            $stmt->close();
            $db->close();
            // Redirect to index.php after successful update
            header('Location: index.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Edit Artist</title>
</head>
<body>
<div class="container px-5">
    <section class="columns is-centered">
        <div class="column is-11">
            <h2 class="title mt-4">Edit Artist</h2>

            <form class="column is-10" action="" method="post">
                <div class="field">
                    <label class="label" for="name">Name</label>
                    <div class="control">
                        <input class="input" id="name" type="text" name="name" value="<?= htmlentities($name) ?>"/>
                    </div>
                    <p class="help is-danger"><?= $errors['name'] ?? '' ?></p>
                </div>

                <div class="field">
                    <label class="label" for="genre">Genre</label>
                    <div class="control">
                        <input class="input" id="genre" type="text" name="genre"
                               value="<?= htmlentities($genre) ?>"/>
                    </div>
                    <p class="help is-danger"><?= $errors['genre'] ?? '' ?></p>
                </div>

                <div class="field">
                    <label class="label" for="albumcount">Albums</label>
                    <div class="control">
                        <input class="input" id="albumcount" type="text" name="albumcount"
                               value="<?= htmlentities($album) ?>"/>
                    </div>
                    <p class="help is-danger"><?= $errors['albumcount'] ?? '' ?></p>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-link is-fullwidth" type="submit" name="submit">Update</button>
                    </div>
                </div>
            </form>

            <a class="button mt-4" href="index.php">&laquo; Go back to the list</a>
        </div>
    </section>
</div>
</body>
</html>
