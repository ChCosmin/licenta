<?php
   $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');
   if (!$con) {
      echo "Error: " . mysqli_connect_error();
    exit();
   }
  $insert = "INSERT INTO carti(titlu) values('".$_POST['titlu']."')";
  mysqli_query($con, $insert);
?>
<a href="../toate_cartile.php">Vezi modificarea!</a><br>
<a href="adaugare.html">Adauga inca un titlu!</a>