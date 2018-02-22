<?php
  session_start();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
     <meta charset="utf-8">
     <title>FMA Web Development with php</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link rel="stylesheet" href="../asset/main_style.css">
   </head>
   <body>
     <main class="container logout text-center">
       <h1 class="display-4">Sure you want to log out?</h1>
       <p>Once logged out all the session and cookies will be deleted!</p>
       <?php
        if(isset($_POST['submit'])){
          //session if user click button logout the session will be destroyed and
          //then redirected to the index.php
          session_destroy();
          header("location: ../index.php");
        }
        $self = htmlentities($_SERVER['PHP_SELF']);
        $output ='<form action="' . $self . '"method="post">
          <div>
            <input class="btn btn-outline-dark" type="submit" name="submit" value="Logout">
          </div>
        </form>';
          echo $output;
       ?>
     </main>
   </body>
 </html>
