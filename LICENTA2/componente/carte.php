<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect      = $root . '/componente/conectare.php';
  $header       = $root . '/componente/header.php';
  $footer       = $root . '/componente/footer.php';
  $adaugaComent = $root . '/actiuni/adauga_comentariu.php';

  session_start();
  include($connect);
  include($header); 

  $id_carte = $_GET['id_carte'];
  $select = "SELECT titlu, nume_autor, descriere, pret FROM carti, autori WHERE id_carte=".$id_carte." AND carti.id_autor=autori.id_autor";
  $resursa = mysqli_query($con, $select);
  $row = mysqli_fetch_array($resursa);

  // define variables and set to empty values
    // $name = $email  = $comment = "";
    // $nameErr = $emailErr = $comentErr = "";

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //   if (empty($_POST["nume_utilizator"])) {
    //     $nameErr = "*Numele este necesar";
    //   } else {
    //     $name = test_input($_POST["nume_utilizator"]);
    //   }
    
    //   if (empty($_POST["adresa_email"])) {
    //     $emailErr = "*Emailul este necesar";
    //   } else {
    //     $email = test_input($_POST["adresa_email"]);
    //   }

    //   if (empty($_POST["comentariu"])) {
    //     $comentErr = "*Campul nu poate fi gol";
    //   } else {
    //     $comment = test_input($_POST["comentariu"]);
    //   }  

    //   if($nameErr === '' && $emailErr === '' && $comentErr === ''){
    //     include($adaugaComent);
    //   } else {
    
    //   }
    // }

    // function test_input($data) {
    //   $data = trim($data);
    //   $data = stripslashes($data);
    //   $data = htmlspecialchars($data);
    //   return $data;
    // }

  
  ?>

<div class="main-content carte-content">
  <section class="carte-section-left">
    <div class="carte">
      <?php
        $adresaImg = "../assets/covers/coperte".$id_carte.".jpg";
        $faraCoperta = "../assets/covers/no-cover.jpg";

        if(file_exists($adresaImg)){
          print '<img class="carte-coperta" src="'.$adresaImg.'" alt="book-cover" />';
        } else {
          print '<img class="carte-coperta" src="'.$faraCoperta.'" alt="book-cover" />';
        }
      ?>
      <div class="carte-detalii">
        <h2 class="carte-titlu italic"><?=$row['titlu']?></h2>
        <i>de <b><?=$row['nume_autor']?></b></i>
        <p class="carte-descriere"><b>"</b> <?=$row['descriere']?> <b>"</b></p>
      
        <form class="carte-cumpara" action="cos.php?actiune=adauga" method="POST">
          <input type="hidden" name="id_carte"   value="<?=$id_carte?>">
          <input type="hidden" name="titlu"      value="<?=$rowCarte['titlu']?>">
          <input type="hidden" name="nume_autor" value="<?=$rowCarte['nume_autor']?>">
          <input type="hidden" name="pret"       value="<?=$rowCarte['pret']?>">
          <h5 class="carte-pret italic">Pret: <?=$row['pret']?> lei</h5>
          <input class="btn btn-primary carte-cumpara-btn " type="submit" value="Cumpara acum!">
        </form>
      </div>
    </div>
    <div class="carte-adauga-coment">
      <h5 class="bold italic adauga-coment-titlu">Adauga opinia ta:</h5>
      <form class="carte-coment-box" action="" id="x">
        <input id="nume_utilizator" class="coment-box-input" type="text" name="nume_utilizator" placeholder="Nume">
        <input id="adresa_email" class="coment-box-input" type="email" name="adresa_email" placeholder="Email">

        <span id="numeErr"class="width50 error"></span>
        <span id="emailErr" class="width50 error"></span>

        <textarea id="comentariu" class="width100 coment-box-textarea" name="comentariu" cols="45" placeholder="Adauga opinia ta despre carte" maxlength="1000"></textarea>
        <span id="comentErr" class="width100 error"></span>

        <input id="id_carte" type="hidden" name="id_carte" value="<?=$id_carte?>">
        <input id="submit" class="btn btn-primary coment-box-btn" type="submit" value="Adauga">
      </form>
    </div>
  </section>

  <section class="carte-section-right">
    <div class="comentarii">
      <h5 class="comentarii-titlu bold italic">Opiniile cititorilor</h5 >
      <?php
        $selectComentarii = "SELECT * FROM comentarii WHERE id_carte=".$id_carte;
        $resursaComentarii = mysqli_query($con, $selectComentarii);
        while($row = mysqli_fetch_array($resursaComentarii)){
          print '<div class="comentariu">
            <a class="bold comentariu-user" href="mailto:'.$row['adresa_email'].'">'.$row['nume_utilizator'].'</a>
            <p class="comentariu-text">'.$row['comentariu'].'</p>
          </div> ';
        }
      ?>
    </div>
  </section> 
</div>

<?php include($footer); ?>
