<?php
require('database.php');
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Add a song</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<!-- the body section -->
<body>
    <header><h1>Your Music</h1></header>

    <main>
        <center><h1 id="addSongHeader">Add a Song</h1></center>
        <form action="add_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
            <label>Playlist:</label>
            <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <br>

            <label>Albums:</label>
            <input type="input" name="Albums">
            <br>

            <label>Name:</label>
            <input type="input" name="name">
            <br>

            <label>Artist:</label>
            <input type="input" name="artist">
            <br>

            <label>Release Date:</label>
            <input type="input" name="releasedate">
            <br>

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>
            <label>&nbsp;</label>
            <input type="submit" value="Add Record">
            <br>
        </form>
        <p><a href="index.php">Homepage</a></p>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PHP CRUD, Inc.</p>
    </footer>
</body>
</html>