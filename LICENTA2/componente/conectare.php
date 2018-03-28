<?php
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'librarie_licenta';

  // create conection
  $con = mysqli_connect($servername, $username, $password, $dbname);
  //check conection
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>