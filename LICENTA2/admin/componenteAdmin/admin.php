<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $headerAdmin    = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $adminComands = $root . '/admin/componenteAdmin/adminComands.php';
  $autorizare = $root . '/admin/componenteAdmin/autorizareAdmin.php';


  include($autorizare);
  include($headerAdmin);
?>

<?php include($footerAdmin); ?>
