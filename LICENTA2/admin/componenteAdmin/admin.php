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
  <div class="admin-main-welcome">
    <h1 class="admin-main-welcome-title">Welcome to the Admin Panel</h1>
    <div class="admin-main-welcome-comands">
      <h4>Comenzi valabile</h4>
      <ul>
        <li><strong>Adauga</strong> - domenii / autori / carti</li>
        <li><strong>Modifica sau sterge</strong> - domenii / autori / carti</li>
        <li><strong>Opinii vizitatori</strong> - modereaza comentariile utilizatorilor pentru diferitele carti</li>
        <li><strong>Comenzi</strong> - modereaza comenzile facute de utilizatori</li>
      </ul>
    </div>
  </div>
  <!-- <h1 class="bold">Modificare carte nu face update, rework</h1>
  <h1 class="bold">Emailurile nu se trimit, rework</h1>
  <h1 class='bold'>f_autorizare nu cred ca fucntioneaza</h1> -->
</div>

<?php include($footerAdmin); ?>
