<?php 
  $root      = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $headerAdmin    = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $firstPageAdmin = $root . '/admin/componenteAdmin/firstPageAdmin.php';
  session_start();
  include($headerAdmin);
  include($firstPageAdmin);
  include($footerAdmin);
?>
