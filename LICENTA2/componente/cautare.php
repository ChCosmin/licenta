<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';

  $carte = $path . '/componente/carte.php';
  $autor = $path . '/componente/autor.php';


  session_start();
  include($connect);
  include($header);
  $cuvant = $_GET['cuvant'];
?>
<div class="main-content cautare-content">
  <h2 class="width100 cautare-titlu">Rezultatele cautarii</h2>
  <p class="width100">Textul cautat: <b><?php echo $cuvant ?></b></p>
  <div class="cautare-list">
    <h6 class="width100 bold">Autori:</h6>
    <blockquote class="cautare-blockquote">
      <?php 
        $sql = "SELECT id_autor, nume_autor FROM autori WHERE nume_autor LIKE '%".$cuvant."%'";
        $resursa = mysqli_query($con, $sql);
        if(mysqli_num_rows($resursa) == 0){
          print '<i>Nici un rezultat</i>';
        }
        while($row = mysqli_fetch_array($resursa)){
          // $nume_autor = str_replace($cuvant, "<b>$cuvant</b>", $row['nume_autor']);
          print "<a href='".$autor."?id_autor=".$row['id_autor']."'>".$row['nume_autor']."</a><br/>";
        }
      ?>
    </blockquote>
  </div>
  <hr class="my-2">

  <div class="cautare-list">
    <h6 class="width100 bold">Titluri:</h6>
    <blockquote class="cautare-blockquote">
      <?php 
        $sql2 = "SELECT id_carte, titlu FROM carti WHERE titlu LIKE '%".$cuvant."%'";
        $resursa2 = mysqli_query($con, $sql2);
        if(mysqli_num_rows($resursa2) == 0){
          print '<i>Nici un rezultat</i>';
        }
        while($row = mysqli_fetch_array($resursa2)){
          // $titlu = str_replace($cuvant, "<b>$cuvant</b>", $row['titlu']);
          print "<a href='".$carte."?id_carte=".$row['id_carte']."'>".$row['titlu']."</a><br/>";
        }
      ?>
    </blockquote>
  </div>
  <hr class="my-2">

  <div class="cautare-list">
    <h6 class="width100 bold">Descrieri:</h6>
    <blockquote class="cautare-blockquote">
      <?php 
        $sql3 = "SELECT id_carte, titlu, descriere FROM carti WHERE descriere LIKE '%".$cuvant."%'";
        $resursa3 = mysqli_query($con, $sql3);
        if(mysqli_num_rows($resursa3) == 0){
          print '<i>Nici un rezultat</i>';
        }
        while($row = mysqli_fetch_array($resursa3)){
          // $descriere = str_replace($cuvant, "<b>$cuvant</b>", $row['descriere']);
          print "<div class='width100 cautare-descriere'><a href='".$carte."?id_carte=".$row['id_carte']."'>".$row['titlu']."</a><i>".$row['descriere']."</i></div></br>";
        }
      ?>
    </blockquote>
  </div>

</div>

<?php include($footer); ?>