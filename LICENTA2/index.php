    <?php 
      $root      = $_SERVER['DOCUMENT_ROOT']."/licenta2";
      $connect   = $root . '/componente/conectare.php';
      $header    = $root . '/componente/header.php';
      $footer    = $root . '/componente/footer.php';
      $firstPage = $root . '/componente/firstPage.php';
      
      session_start();

      include('assets/ChromePhp.php');
      ChromePhp::log($_SESSION);
      include($connect);
      include($header);
      include($firstPage); 
      include($footer);
    ?>

    

