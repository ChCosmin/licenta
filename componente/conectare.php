<?php
  $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

  if (!$con) {
      echo "Error: " . mysqli_connect_error();
    exit();
  }
?>