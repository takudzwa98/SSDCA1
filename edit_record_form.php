<?php
require('database.php');
$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM records
          WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':record_id', $record_id);
$statement->execute();
$record = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Your Music</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="styles/main.scss">
    <link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<!-- the body section -->
<body>
    <header><h1>Your Music</h1></header>
    
    <main>
           
        <center><h1>Edit Your Song</h1></center>
        <form action="edit_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
            <input type="hidden" name="original_image" value="<?php echo $record['image']; ?>" />
            <input type="hidden" name="record_id"
                   value="<?php echo $record['recordID']; ?>">
            <label>Category ID:</label>
            <input type="category_id" name="category_id"
                   value="<?php echo $record['categoryID']; ?>">
            <br>
            <label>Albums:</label>
            <input type="input" name="Albums"
                   value="<?php echo $record['Albums']; ?>">
            <br>
            <label>Song Name:</label>
            <input type="input" name="name"
                   value="<?php echo $record['name']; ?>">
            <br>
            <label>Artist:</label>
            <input type="input" name="artist"
                   value="<?php echo $record['artist']; ?>">
            <br>
            <label>Release Date:</label>
            <input type="input" name="releasedate"
                   value="<?php echo $record['releasedate']; ?>">
            <br>
            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>
            <?php if ($record['image'] != "") { ?>
            <p><img src="image_uploads/<?php echo $record['image']; ?>" height="150" /></p>
            <?php } ?>
            <label>&nbsp;</label>
            <input type="submit" value="Save Changes">
            <br>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PHP CRUD, Inc.</p>
    </footer>
</body>
</html>