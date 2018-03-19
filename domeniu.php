<?php
  session_start();
  function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
  }
  include("./componente/conectare.php");
  include("./componente/page_top.php");
  include("./componente/meniu.php");
  $id_domeniu = $_GET['id_domeniu'];
  $selectDomeniu = "SELECT nume_domeniu FROM domenii WHERE id_domeniu=".$id_domeniu;
  $resursaDomeniu = mysqli_query($con, $selectDomeniu);
  $numeDomeniu = mysqli_result($resursaDomeniu, 0, "nume_domeniu");
?>
<td valign="top">
  <h1>Domeniu: <?=$numeDomeniu?></h1>
  <b>Carti in domeniul <u><i><?=$numeDomeniu?></i></u>:</b>
  <table cellpadding="5">
    <?php
      $select = "SELECT id_carte, titlu, descriere, pret, nume_autor FROM carti, autori, domenii WHERE carti.id_domeniu=domenii.id_domeniu AND carti.id_autor=autori.id_autor AND domenii.id_domeniu=".$id_domeniu;
      $resursa = mysqli_query($con, $select);
      while($row = mysqli_fetch_array($resursa)){
    ?>
    <tr>
      <td align="center">
        <?php
          $adresaImg = "assets/img/coperte".$row['id_carte'].".jpg";
          if(file_exists($adresaImg)){
            print '<img src="'.$adresaImg.'" width="75" height="100"><br>';
          } else {
            print '<div class="no-image">Fara imagine</div>';
          }
        ?>
      </td>
      <td>
        <b><a href="carte.php?id_carte=<?=$row['id_carte']?>"><?=$row['titlu']?></a></b><br>
        <i>de <?=$row['nume_autor']?></i><br>
        Pret: <?=$row['pret']?> lei 
      </td>
    </tr>
    <?php     
      }
    ?>
  </table>
</td>
<?php   include("./componente/page_bottom.php");
 ?>  