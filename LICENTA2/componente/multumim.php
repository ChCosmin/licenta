<?php  
  // $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  // $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';

  session_start();

  // include($connect);
  include($header);
?>
<div class="main-content multumim-content">
  <div class="jumbotron">
    <h1 class="display-4 bold">Multumim!</h1>
    <hr class="my-4">
    <p class="lead">Va multumim ca ati cumparat de la noi! Veti primi comanda solicitata in cel mai scurt timp.</p>  
    <p class="lead">
      <a class="btn btn-primary btn-lg multumim-btn" href="<?php echo $path ?>" role="button">Prima pagina</a>
    </p>
  </div>
</div>


<?php include($footer); ?>