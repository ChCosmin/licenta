<?php 
  $root = '/licenta2';
  $domeniuPath = $root . '/componente/domeniu.php';
?>

<ul class="navbar-nav mr-auto unselectable owl-carousel owl-theme">
  <?php 
    $domenii = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
    $resultatDomenii = mysqli_query($con, $domenii);
    while($row = mysqli_fetch_array($resultatDomenii)){
      print '<li class="nav-item "><a class="nav-link unselectable" href="'.$domeniuPath.'?id_domeniu='.$row['id_domeniu'].'">'.$row['nume_domeniu'].'</a></li>';
    }
  ?>
</ul>
   