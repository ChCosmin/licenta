    <?php 
      $root      = $_SERVER['DOCUMENT_ROOT']."/licenta2";
      $connect   = $root . '/componente/conectare.php';
      $header    = $root . '/componente/header.php';
      $footer    = $root . '/componente/footer.php';
      $firstPage = $root . '/componente/firstPage.php';
      include('assets/ChromePhp.php');

      session_start();
      // if($_SESSION) {
      $_SESSION['titlu']=[];
      $_SESSION['id_carte']=[];
      $_SESSION['nume_autor']=[];
      $_SESSION['pret']=[];
      $_SESSION['nr_buc']=[];

      // } else {
      //   ChromePhp::log($_SESSION);
      // }
      
      include($connect);
      include($header);
      include($firstPage); 
      include($footer);
    ?>

    

