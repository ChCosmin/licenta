<?php
    $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

    if (!$con) {
        echo "Error: " . mysqli_connect_error();
      exit();
    }
  $update = "UPDATE carti SET titlu='".$_POST['titlu']."', descriere='".$_POST['descriere']."', pret='".$_POST['pret']."', data='".$_POST['data']."' WHERE id_carte=".$_POST['id_carte'];
  mysqli_query($con, $update);
  header("location: ../lista_carti.php");
?>