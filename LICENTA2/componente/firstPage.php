<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $carte = $path . '/componente/carte.php';
  $autor = $path . '/componente/autor.php';
?>

<main class="main-content">  
  <section class="left-section">
    <h4 class="section-name">Cele mai noi carti</h4>
    <div class="new-books">
      <?php
        $select = "SELECT id_carte, titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor ORDER BY data LIMIT 0,8";
        $resursa = mysqli_query($con, $select);
        while($row = mysqli_fetch_array($resursa)){
          $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$row['nume_autor']."'";
          $resursaAutor = mysqli_query($con, $autorQ);
          $rowAutor = mysqli_fetch_array($resursaAutor);
          print '<div class="card card-style">';
          $adresaImg = "assets/covers/coperte".$row['id_carte'].".jpg";
          if(file_exists($adresaImg)){
            print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover">';
          } else {
            print '<img class="card-img-top" src="assets/covers/no-cover.jpg" alt="book-cover" />';
          }
          print '
            <div class="card-body">
              <h6 class="card-title">'.$row['titlu'].'</h6>
              <p class="card-text">- de <a href="'.$autor.'?id_autor='.$rowAutor["id_autor"].'"><i>'.$row['nume_autor'].'</i></a><br>
              Pret: '.$row['pret'].' lei</p>
              <a class="btn btn-primary firstPage-detalii-btn" href="'.$carte.'?id_carte='.$row['id_carte'].'">Detalii</a>
            </div>
          </div>';
        }
      ?>
    </div> 
  </section>  
    
  <section class="right-section">
    <h4 class="section-name">Cele mai populare carti</h4>
    <div class="popular-books">
      <?php
        $selectVanzari = "SELECT id_carte, sum(nr_buc) AS bucatiVandute FROM vanzari GROUP BY id_carte ORDER BY bucatiVandute DESC LIMIT 0,6";
        $resursaVanzari = mysqli_query($con, $selectVanzari);
        while($rowVanzari = mysqli_fetch_array($resursaVanzari)){
          $selectCarte = "SELECT titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor AND id_carte=".$rowVanzari['id_carte'];
          $resursaCarte = mysqli_query($con, $selectCarte);
          while($rowCarte = mysqli_fetch_array($resursaCarte)){
            $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$rowCarte['nume_autor']."'";
            $resursaAutor = mysqli_query($con, $autorQ);
            $rowAutor = mysqli_fetch_array($resursaAutor);
            print '<div class="card card-style">';
            $adresaImg2 = "assets/img/coperte".$rowVanzari['id_carte'].".jpg";
            if(file_exists($adresaImg2)){
              print '<img class="card-img-top" src="'.$adresaImg2.'" alt=>';   
            } else {
              print '<img class="card-img-top" src="assets/covers/no-cover.jpg" alt="book-cover" />';
            }
            print '
              <div class="card-body">
                <h6 class="card-title">'.$rowCarte['titlu'].'</h6>
                <p class="card-text">- de <a href="'.$autor.'?id_autor='.$rowAutor["id_autor"].'"><i>'.$rowCarte['nume_autor'].'</i></a><br>
                Pret: '.$rowCarte['pret'].' lei</p>
                <a class="btn btn-primary firstPage-detalii-btn" href="'.$carte.'?id_carte='.$rowVanzari['id_carte'].'">Detalii</a>
              </div>
            </div>';
          }
        }
      ?>
    </div>
  </section>
</main>
