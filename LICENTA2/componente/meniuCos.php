<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $cosIcon = $path . '/assets/img/cos-icon.png';
  $cosPath = $path . '/componente/cos.php';
  // include('assets/ChromePhp.php');
?>

<a href="<?php echo $cosPath ?>" class="meniu-cos-container">
  <div class="cos-icon-container"><img class="cos-icon" src="<?php echo $cosIcon ?>" alt="cos icon"/></div>
  <?php
    $nrCarti = 0;
    $totalValoare = 0;

    for ($i = 0; $i < count($_SESSION['titlu']); $i++){
      $nrCarti = $nrCarti + $_SESSION['nr_buc'][$i];
      $totalValoare = $totalValoare + ($_SESSION['nr_buc'][$i] * $_SESSION['pret'][$i]);
    }
    // ChromePhp::log($_SESSION);

  ?>
  <span class="meniu-cos-nrCarti"><?=$nrCarti?></span>
  <span class="meniu-cos-totalValoare"><?=$totalValoare?> lei</span>
  <!-- <a href="../licenta/cos.php">Click aici pentru a vedea continutul cosului!</a> -->
</a>