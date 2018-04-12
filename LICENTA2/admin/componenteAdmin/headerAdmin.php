<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $adminPath = $path . '/admin/componenteAdmin/admin.php';

  $logoPath = $path . '/assets/img/logo.png';
  $stylesPath = $path . '/admin/indexAdmin.css';
  $globalCSS = $path . '/globals.css';

  $adauga = $path . '/admin/componenteAdmin/adaugare.php';
  $modif_sterg = $path . '/admin/componenteAdmin/modificare_stergere.php';
  $opinii = $path . '/admin/componenteAdmin/opinii.php';
  $comenzi = $path . '/admin/componenteAdmin/comenzi.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Licenta - admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="<?= $globalCSS ?>?v=<?=time();?>">
  <link rel="stylesheet" type="text/css" href="<?= $stylesPath ?>?v=<?=time();?>">

</head>
<body>
  <header class="admin-header">
    <nav class="navbar navbar-expand-lg bg-dark">
      <a class="navbar-brand" href="<?= $adminPath ?>">
        <img height='50' src="<?= $logoPath ?>" alt='logo image'/>   
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="width100 navbar-nav mr-auto unselectable owl-carousel owl-theme">    
          <li class="nav-item bold">COMENZI ADMIN:</li>     
          <li class="nav-item "><a href="<?=$adauga?>">Adauga</a></li>
          <li class="nav-item "><a href="<?=$modif_sterg?>">Modifica sau sterge</a></li>
          <li class="nav-item "><a href="<?=$opinii?>">Opinii vizitatori</a></li>
          <li class="nav-item "><a href="<?=$comenzi?>">Comenzi</a></li>
        </ul>
      </div>
    </nav>
  </header>
