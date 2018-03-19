Alege una din carti si apasa butonul Modifica:
<form action="./actiuni/modifica.php" method="POST">
  <?php
      $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

      if (!$con) {
          echo "Error: " . mysqli_connect_error();
        exit();
      }
    $select = "SELECT id_carte, titlu, descriere, pret, data FROM carti";
    $resursa = mysqli_query($con, $select);
    while ($row = mysqli_fetch_array($resursa)){
      print "
      <input type='radio' name='id_carte' value='".$row['id_carte']."'>
      <b>".$row['titlu']."</b><br>
      <i>".$row['descriere']."</i><br>
      <i>".$row['pret']."</i><br>
      <i>".$row['data']."</i><br><br>";
    }
  ?>
  <input type="submit" value="Modifica">
</form>