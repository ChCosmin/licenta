<?php
    $con = @mysqli_connect('localhost', 'root', '', 'librarie_licenta');

    if (!$con) {
        echo "Error: " . mysqli_connect_error();
      exit();
    }
  $select = "SELECT id_carte, titlu from carti";
  $resurse = mysqli_query($con, $select);
  print "<table border='1'>";
  while ($row = mysqli_fetch_array($resurse)){
    print 
    "<tr>
      <td>".$row['id_carte']."</td>
      <td>".$row['titlu']."</td>
    </tr>";
  }
  print "</table>";
?>