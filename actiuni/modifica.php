Modifica aceasta carte:
<form action="modifica_act.php" method="POST">
  <?php
      $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

      if (!$con) {
          echo "Error: " . mysqli_connect_error();
        exit();
      }

    $select = "SELECT titlu, descriere, pret, data FROM carti WHERE id_carte=".$_POST['id_carte'];
    $resursa = mysqli_query($con, $select);
    while ($row = mysqli_fetch_array($resursa)){
      print '
      Titlu<br><input type="text" name="titlu" value="'.$row['titlu'].'"><br>
      Descriere<br><textarea name="descriere">'.$row['descriere'].'</textarea><br>
      Pret<br><input type="number" name="pret" value="'.$row['pret'].'" min="0" max="10000000000" step="1"><br>
      Data<br><input type="date" name="data" value="'.$row['data'].'"><br><br><br>';
    }
    print '<input type="hidden" name="id_carte" value="'.$_POST['id_carte'].'">';
  ?>
  <input type="submit" value="Modifica">
</form>