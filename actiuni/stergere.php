Sterge un titlu din baza de date:
<form action="stergere_act.php" method="POST">
  <select name="id_carte">
  <?php    
      $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

      if (!$con) {
          echo "Error: " . mysqli_connect_error();
        exit();
      }
    $select = "SELECT id_carte, titlu FROM carti ORDER BY titlu ASC";
    $resurse = mysqli_fetch_array($select);
    while ($row = mysqli_fetch_array($resurse)){
      print "<option value='".$row['id_carte']."'>".$row['titlu']."</option>";
    }     
  ?>
  </select>
  <input type="submit" value="Sterge">
</form>