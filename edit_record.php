<?php
// Get the data
$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$Albums = filter_input(INPUT_POST, 'Albums');
$name = filter_input(INPUT_POST, 'name');
$artist = filter_input(INPUT_POST, 'artist');
$releasedate = filter_input(INPUT_POST, 'releasedate');
// Validate inputs
if ($record_id == NULL || $record_id == FALSE || $category_id == NULL ||
$category_id == FALSE || empty($Albums) || empty($name) || empty($artist) || empty($releasedate) ||
 $releasedate == FALSE) {
$error = "Invalid data. Check all fields and try again.";
include('error.php');
} else {
// Image upload
$imgFile = $_FILES['image']['name'];
$tmp_dir = $_FILES['image']['tmp_name'];
$imgSize = $_FILES['image']['size'];
$original_image = filter_input(INPUT_POST, 'original_image');
if ($imgFile) {
$upload_dir = 'image_uploads/'; // upload directory	
$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
$image = rand(1000, 1000000) . "." . $imgExt;
if (in_array($imgExt, $valid_extensions)) {
if ($imgSize < 5000000) {
if (filter_input(INPUT_POST, 'original_image') !== "") {
unlink($upload_dir . $original_image);                    
}
move_uploaded_file($tmp_dir, $upload_dir . $image);
} else {
$errMSG = "Sorry, your file is too large it should be less then 5MB";
}
} else {
$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
}
} else {
// If no image selected the old image remain as it is.
$image = $original_image; // old image from database
}
// End Image upload

// If valid, update the records in the database
require_once('database.php');
$query = 'UPDATE records
SET categoryID = :category_id,
Albums = :Albums,
name = :name,
artist = :artist,
releasedate = :releasedate,
image = :image
WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':category_id', $category_id);
$statement->bindValue(':Albums', $Albums);
$statement->bindValue(':name', $name);
$statement->bindValue(':artist', $artist);
$statement->bindValue(':releasedate', $releasedate);
$statement->bindValue(':image', $image);
$statement->bindValue(':record_id', $record_id);
$statement->execute();
$statement->closeCursor();
// Display the index page
include('index.php');
}
?>