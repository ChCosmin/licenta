<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect      = $root . '/componente/conectare.php';
  $header       = $root . '/componente/header.php';
  $footer       = $root . '/componente/footer.php';
  $adaugaComent = $root . '/actiuni/adauga_comentariu.php';
  $cartePath    = $path . '/componente/carte.php';

  
  session_start();
  include($connect);
  include($header); 

  $id_autor = $_GET['id_autor'];

  $selectAutor = "SELECT nume_autor, descriere, sursa_descriere FROM autori WHERE id_autor=".$id_autor;
  $resursaAutor = mysqli_query($con, $selectAutor);
  $rowAutor = mysqli_fetch_array($resursaAutor);

  $selectCarti = "SELECT id_carte, titlu, pret, nume_autor FROM carti, autori WHERE carti.id_autor=".$id_autor." AND carti.id_autor=autori.id_autor";
  $resursaCarti = mysqli_query($con, $selectCarti);
?>

<div class="main-content autor-content">
  <section class="width40 autor-section-left">
    <?php
      $adresaImgAutor = "../assets/autori/autor".$id_autor.".jpg";
      $faraImgAutor = "../assets/autori/no-img.jpg";

      if(file_exists($adresaImgAutor)){
        print '<img class="autor-imagine" src="'.$adresaImgAutor.'" alt="imagine autor" />';
      } else {
        print '<img class="autor-imagine" src="'.$faraImgAutor.'" alt="imagine autor" />';
      }
    ?>
    <h2 class="autor-nume"><?=$rowAutor['nume_autor']?></h2>
    <?php 
      if($rowAutor['descriere']){
        print '<p class="autor-descriere">'.$rowAutor['descriere'].'</p>';
      } else {
        print '<p class="italic autor-descriere">Nici o descriere gasita</p>';
      }
    ?>
    <?php
      if($rowAutor['sursa_descriere']){
        print '<h5><a class="italic autor-detalii" target="_blank" href="'.$rowAutor['sursa_descriere'].'">Click pentru mai multe detalii</a></h5>';
      }      
    ?>
  </section>
  <section class="width60 autor-section-right">
      <?php
        while($rowCarti = mysqli_fetch_array($resursaCarti)){
          print '<div class="card card-style">';
          $adresaImg = "../assets/covers/coperte".$rowCarti['id_carte'].".jpg";
          $faraImg = "../assets/covers/no-cover.jpg";
          if(file_exists($adresaImg)){
            print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover">';
          } else {
            print '<img class="card-img-top" src="'.$faraImg.'" alt="book-cover" />';
          }
          print '
            <div class="card-body">
              <h6 class="card-title">'.$rowCarti['titlu'].'</h6>
              <p class="card-text">- de <i>'.$rowCarti['nume_autor'].'</i><br>
              Pret: '.$rowCarti['pret'].' lei</p>
              <a class="btn btn-primary firstPage-detalii-btn" href="'.$cartePath.'?id_carte='.$rowCarti['id_carte'].'">Detalii</a>
            </div>
          </div>';
        }
      ?>
  </section>

</div>

<?php include($footer); ?>
