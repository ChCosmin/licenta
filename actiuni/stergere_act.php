<?php  
    $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

    if (!$con) {
        echo "Error: " . mysqli_connect_error();
      exit();
    }
  $delete = "DELETE FROM carti WHERE id_carte=".$_POST['id_carte'];
  mysqli_query($con, $delete);
?>
<a href="../toate_cartile.php">Vezi modificarea!</a>
<a href="stergere.php">Mai sterge una!</a>