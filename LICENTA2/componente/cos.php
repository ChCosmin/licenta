<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';

  $cosPath = $root . '/componente/cos.php';
  $cartePath = $path . '/componente/carte.php';
  $url = $_SERVER['REQUEST_URI'];

  session_start();
  
  include($connect);
  include($header);
  include('../assets/ChromePhp.php');

  $totalGeneral = 0;  

  // adauga carte
  if (isset($_POST['actiune']) && $_POST['actiune'] == 'adauga'){
    $_SESSION['id_carte'][] = $_POST['id_carte'];
    $_SESSION['nr_buc'][] = 1;
    $_SESSION['pret'][] = $_POST['pret'];
    $_SESSION['titlu'][] = $_POST['titlu'];
    $_SESSION['nume_autor'][] = $_POST['nume_autor'];
    $totalGeneral = 0;  
  }

  // modifica valore item
  if (isset($_POST['actiune']) && $_POST['actiune'] == 'modifica'){
    for($i=0; $i<count($_SESSION['id_carte']);$i++){
      $_SESSION['nr_buc'][$i] = $_POST['noulNrBuc'][$i];
    }
    $totalGeneral = 0;  
    header('Location: '. $cosPath);
    exit();
  } 

  // sterge item din cos
  if (isset($_GET['actiune']) && $_GET['actiune'] == 'sterge'){
    $stergeItem = $_GET['item_sters'];
    array_splice($_SESSION['id_carte'], $stergeItem, 1);
    array_splice($_SESSION['pret'], $stergeItem, 1);
    array_splice($_SESSION['titlu'], $stergeItem, 1);
    array_splice($_SESSION['nume_autor'], $stergeItem, 1);
    array_splice($_SESSION['nr_buc'], $stergeItem, 1);
    header('Location: '. $cosPath);
    exit();
  }

  // goleste cos
  if (isset($_GET['actiune']) && $_GET['actiune'] == 'golesteCos'){
    $_SESSION['titlu']=[];
    $_SESSION['id_carte']=[];
    $_SESSION['nume_autor']=[];
    $_SESSION['pret']=[];
    $_SESSION['nr_buc']=[];
    header('Location: '. $cosPath);
    exit();
  }

  // rezumat cos
  $totalCos = 0 ;
  $nrCarti = 0;
  for($i=0; $i<count($_SESSION['id_carte']); $i++){      
    $totalCos = $totalCos + ($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]);
    $nrCarti = $nrCarti + ($_SESSION['nr_buc'][$i]);
  }
  
  // ascunde cos daca este gol
  $cosEmtpy = '';
  if(count($_SESSION['id_carte']) === 0) {
    $cosEmpty = 'none';
  } else {
    $cosEmpty = 'initial';
  }

  if($_POST){
    header('Location: '. $_SERVER['REQUEST_URI']);
    exit();
  }
?>

<div class="main-content cos-container" >
  <h2 class="width100 cos-container-title">Cosul de cumparaturi</h2>
  <div class="width100 cos-summary">
    <img class="cos-summary-icon" width="25" src='../assets/img/cos-icon.png' alt='cos icon'/>
    <p class="cos-summary-text">Ai <?php echo $nrCarti ?> carti in valoare de <b><?php echo $totalCos ?> lei</b> in cos</p>
  </div>
  <p style="display: <?php echo $cosEmpty ?>" class="cos-notif">*schimba cantitatile si apasa modifica</p>
  <form style="display: <?php echo $cosEmpty ?>" class="width100 cos-form" action="<?php $url ?>" method="POST">
    <?php
      for($i=0; $i<count($_SESSION['id_carte']); $i++){      
        print '<div class="cos-container-carte">';
        $adresaImg = '../assets/covers/coperte'.$_SESSION['id_carte'][$i].'.jpg'; 
        if(file_exists($adresaImg)){
          print '<a class="width15" href="'.$cartePath.'?id_carte='.$_SESSION['id_carte'][$i].'"><img class="width100 cos-carte-img" src="'.$adresaImg.'" alt="book-cover" /></a>';
        } else {
          print '<a class="width15" href="'.$cartePath.'?id_carte='.$_SESSION['id_carte'][$i].'"><img class="width100 cos-carte-img" src="../assets/covers/no-cover.jpg" alt="book-cover" /></a>';
        }
        print '<div class="width65 cos-carte-detalii">';
        print '<h5 class="cos-carte-titlu">'.$_SESSION['titlu'][$i].'</h5>';  
        print '<p>de '.$_SESSION['nume_autor'][$i].'</p>';
        print '<div class="italic price-color cos-carte-pret">'.$_SESSION['pret'][$i].' lei</div>';
        print '</div>';

        print '<div class="width20 cos-carte-detalii2">';
        print 'Cantitate <input class="cos-carte-cantitate" type="text" name="noulNrBuc['.$i.']" size="1" value="'.$_SESSION['nr_buc'][$i].'">';
        print '<div class="bold price-color cos-carte-pret-total">'.($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]).' lei</div>';
        print '<a class="cos-carte-sterge" id="item'.$_SESSION['id_carte'][$i].'" href="'.$cosPath.'?actiune=sterge&item_sters='.$i.'">Sterge</a>';
        print '</div>';
        print '</div>';
        $totalGeneral = $totalGeneral + ($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]);
      }
    ?>
    <div class="cos-modifica">
      <input type="hidden" name="actiune" value="modifica" />
      <input class="cos-modifica-btn" type="submit" value="Modifica" />
      <a class="cos-reset-btn" href="<?php echo $cosPath ?>?actiune=golesteCos">Goleste cosul</a>
    </div>

    <div class="cos-container-pretTotal">
      <div class="width70 cos-pretTotal1"><p>Transport</p><p class="bold price-color">Total</p></div>
      <div class="width30 cos-pretTotal2"><p>Gratuit</p><p class="bold price-color"><?php echo $totalGeneral ?> lei</p></div>
    </div>
        
    <div class="cos-actiuni">
      <div class="width50 cos-actiuni-continua">
        <img width="25" src="../assets/img/left-arrow.gif">
        <a class="cos-actiuni-linkContinua" href="../index.php">Continua cumparaturi</a>
      </div>
      <div class="width50 cos-actiuni-casa">
        <a class="cos-actiuni-linkCasa" href="casa.php">Mergi la casa</a>
        <img width="25" src="../assets/img/cos-icon.gif">
      </div>
    </div>
  </form>
</div>

<?php include($footer) ?>