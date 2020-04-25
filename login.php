<?php

//login.php

/**
 * Start the session.
 */
session_start();


/**
 * Include ircmaxell's password_compat library.
 */
require 'libary-folder/password.php';

/**
 * Include our MySQL connection.
 */
require 'login_connect.php';


//If the POST var "login" exists (our submit button), then we can
//assume that the user has submitted the login form.
if(isset($_POST['login'])){
    
    //Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $emailadress = !empty($_POST['emailadress']) ? trim($_POST['emailadress']) : null;
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT id, username, password, emailadress FROM users WHERE username = :username AND emailadress = :emailadress";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':emailadress', $emailadress);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
   
    
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        echo "Incorrect password";
        header('Location: loginfailed
        .php');
        
    } 
    else
    {
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
        //Compare the passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);
        $validemail = password_verify($emailAttempt, $user['emailadress']);

        
        //If $validPassword is TRUE, the login has been successful.
        if($validPassword){
            
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            
            //Redirect to our protected page, which we called home.php
            header('Location: manage_songs.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
        if($validemail){
            
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            
            //Redirect to our protected page, which we called home.php
            header('Location: manage_songs.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
    }
    
}
 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles_2/register.css">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Login</title>
    </head>
    <body>
    <?php include './includes/header2.php';?>
     
        <br>
        <br>
        <br>
        <form action="login.php" style="max-width:500px;margin:auto" method="post">
 
  



 <div class="input-container">
     <i class="fa fa-user icon"></i>
     <input class="input-field" type="text" placeholder="Username" name="username">
   </div>
 
   <div class="input-container">
     <i class="fa fa-envelope icon"></i>
     <input class="input-field" type="text" placeholder="Email Address" name="emailadress">
   </div>
   
   <div class="input-container">
     <i class="fa fa-key icon"></i>
     <input class="input-field" type="password" placeholder="Password" name="password">
 
 </div>

 <button type="submit" class="btn" name="login" >Log In</button>
   </div>
   <button><a href="index.php" class="" >Home</a></button>
   <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
 

     </body>
     <?php include './includes/footer.php';?>
 </html>