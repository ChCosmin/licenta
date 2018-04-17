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

<div class="admin-main-content">
<h1 class="bold">Modificare carte nu face update, rework</h1>
<h1 class="bold">Emailurile nu se trimit, rework</h1>
<h1 class='bold'>f_autorizare nu cred ca fucntioneaza</h1>
</div>


<?php include($footerAdmin); ?>
