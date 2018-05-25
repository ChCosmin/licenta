<?php 
  $root      = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';
  $firstPage = $root . '/componente/firstPage.php';
  include('assets/ChromePhp.php');
  session_start();
  if($_SESSION){
    ChromePhp::log("SESSION EXISTS");
    ChromePhp::log($_SESSION);
    
  } else {
    ChromePhp::log("SESSION DOESNT EXISTS");    
    ChromePhp::log($_SESSION);
    
  }
  // $_SESSION['titlu']=[];
  // $_SESSION['id_carte']=[];
  // $_SESSION['nume_autor']=[];
  // $_SESSION['pret']=[];
  // $_SESSION['nr_buc']=[];
  
  
  include($connect);
  include($header);
  include($firstPage); 
  include($footer);
?>

    

