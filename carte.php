<?php
  session_start();
  include("./componente/conectare.php");
  include("./componente/page_top.php");
  include("./componente/meniu.php");   
  $id_carte = $_GET['id_carte'];
  $select = "SELECT titlu, nume_autor, descriere, pret FROM carti, autori WHERE id_carte=".$id_carte." AND carti.id_autor=autori.id_autor";
  $resursa = mysqli_query($con, $select);
  $row = mysqli_fetch_array($resursa);
?>
<td valign="top">
  <table>
    <tr>
      <td valign="top">
        <?php
          $adresaImg = "./assets/img/coperte".$id_carte.".jpg";
          if(file_exists($adresaImg)){
            print '<img src="'.$adresaImg.'" width="75" height="100" hspace="10"><br>';
          }
        ?>
      </td>
      <td valign="top">
        <h1><?=$row['titlu']?></h1>
        <i>de <b><?=$row['nume_autor']?></b></i>
        <p><i><?=$row['descriere']?></i></p>
        <p>Pret: <?=$row['pret']?> lei</p>
      </td>
    </tr>
  </table>
  <form action="cos.php?actiune=adauga" method="POST">
    <input type="hidden" name="id_carte"   value="<?=$id_carte?>">
		<input type="hidden" name="titlu"      value="<?=$rowCarte['titlu']?>">
		<input type="hidden" name="nume_autor" value="<?=$rowCarte['nume_autor']?>">
		<input type="hidden" name="pret"       value="<?=$rowCarte['pret']?>">
		<input type="submit" value="Cumpara acum!">
  </form>
  <p><b>Opiniile cititorilor</b></p>
  <?php
    $selectComentarii = "SELECT * FROM comentarii WHERE id_carte=".$id_carte;
    $resursaComentarii = mysqli_query($con, $selectComentarii);
    while($row = mysqli_fetch_array($resursaComentarii)){
      print '<div class="commentarii"><a href="mailto:'.$row['adresa_email'].'">'.$row['nume_utilizator'].'</a><br>'.$row['comentariu'].'</div> ';
    }
  ?>
  <br>
  <div class="adauga-opinie">
    <b>Adauga opinia ta:</b>
    <hr size="1">
    <form action="./actiuni/adauga_comentariu.php" method="POST">
      Nume: <input type="text" name="nume_utilizator">
      Email: <input type="email" name="adresa_email"><br><br>
      Comentariu: <br><textarea name="comentariu" cols="45"></textarea><br><br>
      <input type="hidden" name="id_carte" value="<?=$id_carte?>">
      <center><input type="submit" value="Adauga"></center>
    </form>
  </div>
</td>
<?php
  include("./componente/page_bottom.php");
?>
