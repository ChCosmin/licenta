<?php 
  // $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';

  session_start();
  // include($connect);
  include($header);

  $totalGeneral = 0;
?>

<div class="main-content casa-container" >
  <h2 class="width100 casa-container-title">Casa</h2>
  <div class="casa-summary">
    <div class="bold casa-item">
      <p class="width10 center-text casa-item-buc">Nr. buc</p>
      <p class="width50 center-text casa-item-titlu">Titlu &amp; Nume autor</p>
      <p class="width20 center-text casa-item-pret">Pret/buc</p>
      <p class="width20 center-text casa-item-pretItem">Pret Total</p>
    </div>
    <?php 
      for($i=0; $i<count($_SESSION['id_carte']); $i++){
        if($_SESSION['nr_buc'][$i] != 0) {
          print '
          <div class="casa-item">
            <p class="width10 center-text casa-item-buc">'.$_SESSION['nr_buc'][$i].'</p>
            <p class="width50 center-text casa-item-titlu"><b>'.$_SESSION['titlu'][$i].'</b> de '.$_SESSION['nume_autor'][$i].'</p>
            <p class="width20 center-text casa-item-pret">'.$_SESSION['pret'][$i].' lei</p>
            <p class="width20 center-text price-color bold casa-item-pretItem">'.($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]).' lei </p>
          </div>';
          $totalGeneral = $totalGeneral + ($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]);
        }
      }
      print '<div class="bold casa-pret-total"><p class="width10" /><p class="width50" /><p class="center-text width20">Total de plata </p><p class="center-text width20 pret-total price-color">'.$totalGeneral.' lei</p></div>';
    ?>
  </div>
  <h2 class="width100 casa-container-detalii">Detalii</h2>
  <form class="casa-detalii" action="../actiuni/prelucrare.php" method="POST">
    <input class="casa-detalii-input" type="text" name="nume" placeholder="Nume"/> 
    <input class="casa-detalii-input" type="email" name="email" placeholder="Email" />
    <textarea class="casa-detalii-textarea" name="adresa" rows="6" placeholder="Adresa"></textarea>
    <input class="btn btn-primary casa-detalii-btn" type="submit" value="Trimite" />    
  </form>
</div>

<?php include($footer) ?>