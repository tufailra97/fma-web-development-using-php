<?php
  session_start();
  if(empty($_SESSION['access_type'])){
    header('location: ../../index.php');
  }

  /*
      Author: Tufail Rahman
      Student ID: 13303800
      Module: FMA Web Programming using PHP (P1)
      Date 07/01/2018
  */
?>
