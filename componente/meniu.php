  <td valign="top" width="125">
    <div class="domenii">
      <b>Alege domeniul</b><hr size="1">
      <?php
        $select = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
        $resursa = mysqli_query($con, $select);
        while($row = mysqli_fetch_array($resursa)){
          print '<a href="domeniu.php?id_domeniu='.$row['id_domeniu'].'">'.$row['nume_domeniu'].'</a><br>';
        }
      ?>
    </div><br>
    <div class="meniu-form">
      <form action="cautare.php" method="GET">
        <b>Cautare</b><br>
        <input type="text" name="cuvant" size="12"><br>
        <input type="submit" value="Cauta">
      </form>
    </div>
    <br>
    <div class="meniu-form">
      <b>Cos</b><br>
      <?php
        $nrCarti = 0;
        $totalValoare = 0;
        for ($i = 0; $i < count($_SESSION['titlu']); $i++){
          $nrCarti = $nrCarti + $_SESSION['nr_buc'][$i];
          $totalValoare = $totalValoare + ($_SESSION['nr_buc'][$i] * $_SESSION['pret'][$i]);
        }
      ?>
      Aveti <b><?=$nrCarti?></b> carti in cos, in valoare total de <b><?=$totalValoare?></b> lei. 
      <a href="../licenta/cos.php">Click aici pentru a vedea continutul cosului!</a>
    </div>
  </td>