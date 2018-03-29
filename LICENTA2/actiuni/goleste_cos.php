<?php
  ob_start();
  include("../componente/conectare.php");
  include('../assets/ChromePhp.php');

  session_start();
  $_SESSION['titlu']=[];
  $_SESSION['id_carte']=[];
  $_SESSION['nume_autor']=[];
  $_SESSION['pret']=[];
  $_SESSION['nr_buc']=[];

  // $inapoi = "../componente/carte.php?id_carte=".$_POST['id_carte'];
  $inapoi = "../index.php";
  header("location: $inapoi");
?>