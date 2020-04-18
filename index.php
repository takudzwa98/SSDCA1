<?php

// Connect to the database
require_once('database.php');
// Set the default category to the ID of 1
if (!isset($category_id)) {
$category_id = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
$category_id = 1;
}
}
// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];
// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();
// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
  
<title>Your Music</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="styles/main.scss">
<link rel="stylesheet" type="text/css" href="styles_2/main.scss">
<link rel="stylesheet" type="text/css" href="styles/main.css">
<link rel="stylesheet" type="text/css" href="styles/css.css">
</head>

<body>
<div class="navbar">
  <a class="active" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a> 
  <i onclick="document.getElementById('id01').style.display='block'" style="width:auto;></i> Search</a> 
  <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
  <a href="register.php"><i class="fa fa-fw fa-envelope"></i> Register</a> 
  <a href="#">
    
    
  <i class="fa fa-fw fa-user"></i> Login</a>
</div>
<br>
<br>
<?php include './includes/header.php';?>
<main>
<h4 className= "genre"></h4> 
<h3 className= "genre">Playlists</h3>

<br>
<break>

<aside>
<!-- display a list of categories in the sidebar-->

<nav>
<ul>
<?php foreach ($categories as $category) : ?>
<li><a href=".?category_id=<?php echo $category['categoryID']; ?>">
<?php echo $category['categoryName']; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</nav>
</aside>
<section>
<!-- display a table of records from the database -->
<h2><?php echo $category_name; ?></h2>
<table className = "table">
<tr>
<th>Song Art</th>
<th>Song name</th>
<th>Album</th>
<th>Artist</th>
<th>Release Date</th>

</tr>
<?php foreach ($records as $record) : ?>
<tr>
<td><img src="image_uploads/<?php echo $record['image']; ?>" width="100px" height="100px" /></td>
<td><?php echo $record['name']; ?></td>
<td><?php echo $record['Albums']; ?></td>
<td><?php echo $record['artist']; ?></td>
<td><?php echo $record['releasedate']; ?></td>


</tr>
<?php endforeach; ?>
</table>
</section>
</main>

<?php include './includes/footer.php';?>
<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
<div id="id01" class="modal">
  
<form class="modal-content animate" action="login.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="hi.jpg" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      
     <label for="emailadress"><b>Email Adress</b></label>
    <input type="text" placeholder="Enter Email Address" name="emailadress" required>

      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit" name="login" >Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<form action="register.php">
<button class="w3-button w3-black">Register</button>
</form>

</body>
</html>