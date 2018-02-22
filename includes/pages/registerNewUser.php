<?php
  session_start();
  session_regenerate_id(true);
  if(empty($_SESSION['access_type'])){
    header('location: ../main_index.php');
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta charset="utf-8">
    <title>FMA Web Development with php</title>
    <link rel="icon" type="image/png" href="../../asset/img/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../asset/main_style.css">
  </head>
  <body>
    <main class="container reg">
      <?php
      /*========================
      VALIDATION
      ========================

      **
      First Name
        (only letter && between 2,10 letters)
      Last Name
        (only letter && between 2,10 letters)
      Email
        (validate with built in function in php)
      Username
        (4 < length < 12)
      Password
        (8 < length) && (content == ^[a-zA-Z0-9])
      **
      if the validation is successfull then the user will be added to the registered user file.

      */
      $form_is_submitted = false;
      $error_detected = false;

      $clean = array();
      $errors = array();

      if(isset($_POST['submit'])){
        $form_is_submitted = true;
        //check of the variable title exist or not
        if(!empty($_POST['title'])){
          $clean['title'] = $_POST['title'];
        }else{
          $error_detected = true;
          $errors['title'] = 'Title is missing';
        }

        //check if the variable firstname is empty or not
        //if the variable exist then proceed with the validation
        if(empty($_POST['first_name'])){
          $error_detected = true;
          $errors[] = 'Name not submitted';
        }else {
          $name = $_POST['first_name'];
          if(!ctype_alpha($name) || $name < 1 && $name > 10){
            $error_detected = true;
            $errors[] = 'The Name must contain only letter and must be between 2 and 10 letters';
          }else{
            $clean['first_name'] = $name;
          }
        }

        //check if the variable surname is empty or not
        //if the variable exist then proceed with the validation
        if(empty($_POST['surname'])){
          $error_detected = true;
          $errors[] = 'Surname not submitted';
        }else {
          $surname = $_POST['surname'];
          if(!ctype_alpha($surname) || $surname < 1 && $surname > 10){
            $error_detected = true;
            $errors[] = 'The Surnname must contain only letter and must be between 2 and 10 letters';
          }else{
            $clean['surname'] = $surname;
          }
        }

        //check if the variable email is empty or not
        //if the variable exist then proceed with the validation
        // using the php buil in funtion
        if(empty($_POST['email'])){
          $error_detected = true;
          $errors[] = 'Email not submitted';
        }else {
          $email = $_POST['email'];
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error_detected = true;
            $errors[] = 'Invalid Email';
          }else{
            $clean['email'] = $email;
          }
        }

        //check if the variable surname is empty or not
        //if the variable exist then proceed with the validation
        if(empty($_POST['username'])){
          $error_detected = true;
          $errors[] = 'Username not submitted';
        }else {
          $username = $_POST['username'];
          if(ctype_alpha($username)){
            $error_detected = true;
            $errors[] = 'Username must contain at least one number';
          }else {
            if(strlen($username) < 5 || strlen($username) > 16){
              $error_detected = true;
              $errors[] = 'Username must be between 5 and 16';
            }else {
              $clean['username'] = $username;
            }
          }
        }

        //check if the variable password is empty or not
        //if the variable exist then proceed with the validation
        if(empty($_POST['password'])){
          $error_detected = true;
          $errors[] = 'Password not submitted';
        }else {
          $password = $_POST['password'];
          if(ctype_alpha($password)){
            $error_detected = true;
            $errors[] = 'Password must contain at least one number';
          }else {
            if(strlen($password) < 8){
              $error_detected = true;
              $errors[] = 'Password must be more 8 digits';
            }else {
              $clean['password'] = $password;
            }
          }
        }


        //if email and username are submitted correctly, then fetch with the user already
        //registered, if data are fetched, error will be thrown
        if(!empty($clean['username']) && !empty($clean['email'])){
          $users = file('../users_registered.txt');
          $index = sizeof($users)-1;
          $db_user = false;


          //loop through user alredy registered
          while ($index > 0 && $db_user == false){
            $current_user = explode(",", $users[$index]);
            $db_email = $current_user[3];
            $db_username = $current_user[4];

            //fetch username
            if(trim($db_username) == trim($clean['username'])){
              $db_user = true;
              $error_detected = true;
              $errors[] = 'Username already in system!';
            }

            //fetch email
            if(trim($db_email) == trim($clean['email'])){
              $db_user = true;
              $error_detected = true;
              $errors[] = 'Email already in system!';
            }
            $index = $index - 1;
          }
        }

      }

      //if the registration form is submitted correctly then the username and the password
      //for the user newly create will be stored to the user_registered.txt file
      if($form_is_submitted === true && $error_detected === false){
        $user_db = '../users_registered.txt';
        $newUser = implode(",", $clean) ."\r\n";
        //built in php function to add new user to the database
        file_put_contents($user_db, $newUser, FILE_APPEND);

        //if the user is registered successfully then the admin will be
        //redirected to the main index
        echo '<section class="mt-5 jumbotron">';
        echo '<h1 classs="display-4">New user registered successfully!</h1>';
        echo "<h3>Redirection to the main page..</h3>";
        echo "</section>";
        header("refresh:3; url=../main_index.php");
      }else {
        showForm();
        echo '<ul class="mt-4 mb-4 list-group col-md-6">';
        foreach ($errors as $key) {
          echo '<li class="list-group-item list-group-item-danger"><span>'.$key.'</span></li>';
        }
        echo "</ul>";
      }

      //funtcion form to display the form
      function showForm(){
        $self = htmlentities($_SERVER['PHP_SELF']);

        //display form
        $output = '
          <section class="mt-5 col-md-6 border">
            <h1 class="display-4">Register new user</h1>
              <form class="inline_content" action="'. $self .'" method="post">
                <div class="form-group">
                  <label for="title">Title</label>
                  <select class="form-control" name="title">
                    <option value=""></option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>First Name : </label>
                  <input type="text" class="form-control" name="first_name" placeholder="Name">
                </div>
                <div class="form-group">
                  <label>Lastname : </label>
                  <input type="text" name="surname"  class="form-control" placeholder="Lastame">
                </div>
                <div class="form-group">
                  <label>Email : </label>
                  <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                  <label>Username : </label>
                  <input type="text" name="username"  class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                  <label>Password : </label>
                  <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <input type="submit"  class="btn btn-outline-dark"  name="submit" value="Submit">
              </form>
          </section>';



        echo $output;
      }
      ?>
    </main>
  </body>
</html>
