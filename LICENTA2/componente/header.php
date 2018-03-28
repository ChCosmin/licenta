<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $logoPath = $path . '/assets/img/logo.png';
  $stylesPath = $path . '/index.css';
  $meniuStylesPath = $path . '/assets/owl.carousel.min.css';
  $meniuStyleDefaultpath = $path . '/assets/owl.theme.default.min.css';
  $paginationPath = $path . '/assets/zebra_pagination.css';

  $meniuPath = $root . '/componente/meniuDomenii.php';
  $searchPath = $root . '/componente/meniuSearch.php';
  $cosPath = $root . './componente/meniuCos.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="<?php echo $meniuStylesPath ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo $meniuStyleDefaultpath?>" type="text/css">
    <link rel="stylesheet" href="<?php echo $paginationPath?>?v=<?=time();?>" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo $stylesPath ?>?v=<?=time();?>">
    
    <title>Licenta</title>
  </head>
<body>
<header class="header">
  <nav class="navbar navbar-expand-lg bg-dark">
    <a class="navbar-brand" href="<?php echo $path ?>">
      <img height='50' src="<?php echo $logoPath ?>" alt='logo image'/>      
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php 
        include($meniuPath);    
        include($cosPath);   
        include($searchPath);
      ?>
    </div>
  </nav>
</header>
