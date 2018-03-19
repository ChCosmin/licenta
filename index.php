<?php
  session_start();
  include("./componente/conectare.php");
  include("./componente/page_top.php");
  include("./componente/meniu.php");
?>
<td valign="top">
  <h1>Prima pagina</h1>
  <b>Cele mai noi carti</b>
  <table cellpadding='5'>
    <tr>
      <?php
          $select = "SELECT id_carte, titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor ORDER BY data DESC LIMIT 0,3";
          $resursa = mysqli_query($con, $select);
          while($row = mysqli_fetch_array($resursa)){
            print '<td align="center">';
            $adresaImg = "assets/img/coperte".$row['id_carte'].".jpg";
            if(file_exists($adresaImg)){
              print '<div class="book-title"><a href="carte.php?id_carte='.$row['id_carte'].'"><img src="'.$adresaImg.'" width="75" height="100"><br>'.$row['titlu'].'</a></div><br> de <i>'.$row['nume_autor'].'</i><br> Pret: '.$row['pret'].' lei </td>';

            } else {
              print '<div class="no-image">Fara imagine</div>';
              print '<div class="book-title"><a href="carte.php?id_carte='.$row['id_carte'].'">'.$row['titlu'].'</a></div><br> de <i>'.$row['nume_autor'].'</i><br> Pret: '.$row['pret'].' lei </td>';
            }
          }
        ?>
    </tr>
  </table>
  <hr>
  <b>Cele mai populare carti</b>
  <table cellpadding='5'>
    <tr>
      <?php
        $selectVanzari = "SELECT id_carte, sum(nr_buc) AS bucatiVandute FROM vanzari GROUP BY id_carte ORDER BY bucatiVandute DESC LIMIT 0,3";
        $resursaVanzari = mysqli_query($con, $selectVanzari);
        while($rowVanzari = mysqli_fetch_array($resursaVanzari)){
          $selectCarte = "SELECT titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor AND id_carte=".$rowVanzari['id_carte'];
          $resursaCarte = mysqli_query($con, $selectCarte);
          while($rowCarte = mysqli_fetch_array($resursaCarte)){
            print '<td align="center">';
            $adresaImg2 = "assets/img/coperte".$rowVanzari['id_carte'].".jpg";
            if(file_exists($adresaImg2)){
              print '<div class="book-title"><a href="carte.php?id_carte='.$rowVanzari['id_carte'].'"><img src="'.$adresaImg2.'" width="75" height="100"><br>'.$rowCarte['titlu'].'</a></div><br> de <i>'.$rowCarte['nume_autor'].'</i><br> Pret: '.$rowCarte['pret'].'lei </td>';

            } else {
              print '<div class="no-image">Fara imagine</div>';
              print '<div class="book-title"><a href="carte.php?id_carte='.$rowVanzari['id_carte'].'">'.$rowCarte['titlu'].'</a></div><br> de <i>'.$rowCarte['nume_autor'].'</i><br> Pret: '.$rowCarte['pret'].'lei </td>';
            }
          }
        }
      ?>
    </tr>
  </table>
</td>
</tr>
</table>
<?php
  include("./componente/page_bottom.php");
?>
    