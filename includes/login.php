<?php
  $form_is_submitted = false; //boolean variable that will check if the form wheter the for is submitted or not
  $errors_detected = false;   //boolean variable that will check if the form contain any error
  $admin_access = false;      //boolena variable that will check if the admin is loggin in

  // Arrays to gather data
  $clean = array();
  $errors = array();

  if(isset($_POST['submit'])){
    $form_is_submitted = true;
    //if the username is inserted then the password is checked.
    //If both username && password are inserted then the username and password
    //are fetched
    if(!empty($_POST['username'])){
      if (!empty($_POST['password'])) {
        $users = file('./includes/users_registered.txt'); //read the users_registered file into an array
        $username = "";   //variable to store the username
        $password = "";   //variable to store the password
        $index = sizeof($users); //variable that will store the size of the array
        $user_found = false; //boolean to check the username is found or not

        //loop through the users and check if the username and password match
        //use of while loop instead of foreach loop, so in this case once the username and
        //the password are found the loop will stop. This will prevent to loop through the entire
        //array, saving memory and increasing the performance
        while ($index > 0 && $user_found == false){
          $current_user = explode(",", $users[$index-1]);
          $s_username = $_POST['username'];
          $s_password = $_POST['password'];
          $username = $current_user[4];
          $password = $current_user[5];



          if(trim($s_username) == trim($username)){
            if(trim($s_password) == trim($password)){
              //if the data are fetched the assign the value to the clean array
              $clean['username'] = trim($username);
              $clean['password'] = trim($password);
              if(($index-1) == 0 || $s_username == 'admin'){
                $admin_access =  true;
              }
              //if user is found
              $user_found = true;
            }
          }
          $index = $index - 1;
        }

        if($user_found === false){
          $errors_detected = true;
          $errors[] = '<strong>Incorrect username/ password Please try again</strong>';
        }

      }else {
        $errors_detected = true;
        $errors[] = 'Password not submitted';
      }
    }else {
      $errors_detected = true;
      $errors[] = 'Username not submitted';

      if(empty($_POST['password'])){
        $errors[] = 'Password not submitted';
      }
    }
  }



  //if username && password are fetched then insert the value to the superglobal array session
  if($form_is_submitted === true && $errors_detected === false){
    $_SESSION['username'] = $clean['username'];
    $_SESSION['password'] = $clean['password'];

    //if the admin is logged in
    if($admin_access === true){
      $_SESSION['access_type'] = 'admin';
    }else{
      $_SESSION['access_type'] = 'user';
    }
    $path = './includes/main_index.php';
    header('location:'.$path );
  }else{
    //if the form contains error show the form and the errors
    showForm();
    if($errors_detected === true){
      echo "<ul>";
      foreach ($errors as $key ) {
        echo "<li><span>".$key."</span></li>";
      }
      echo "</ul>";
    }
  }


  //funtion for form
  function showForm(){
    $self = htmlentities($_SERVER['PHP_SELF']);
    $output = '<form action="' . $self . '"method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" type="text" name="username" placeholder="Enter username">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <input class="btn btn-outline-light" type="submit" name="submit" value="Submit">
    </form>';
    echo $output;
  }


?>
