<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';

  $cosPath = $root . '/componente/cos.php';

  session_start();
  
  include($connect);
  include($header);
  include('../assets/ChromePhp.php');
  ChromePhp::log($_SESSION);
  $totalGeneral = 0;  

  $actiune = $_GET['actiune'];
  if (isset($_GET['actiune']) && $_GET['actiune'] == 'adauga'){
    $_SESSION['id_carte'][] = $_POST['id_carte'];
    $_SESSION['nr_buc'][] = 1;
    $_SESSION['pret'][] = $_POST['pret'];
    $_SESSION['titlu'][] = $_POST['titlu'];
    $_SESSION['nume_autor'][] = $_POST['nume_autor'];
    $totalGeneral = 0;  
  }
  if (isset($_GET['actiune']) && $_GET['actiune'] == 'modifica'){
    for($i=0; $i<count($_SESSION['id_carte']);$i++){
      $_SESSION['nr_buc'][$i] = $_POST['noulNrBuc'][$i];
    }
    $totalGeneral = 0;  
  } 
  ChromePhp::log($_SESSION);

?>

<div class="main-content cos-container">
  <h1>Cosul de cumparaturi</h1>
  <form action="<?php echo $cosPath ?>?actiune=modifica" method="POST">
    <table border='1' cellspacing="0" cellpadding="4">
      <tr bgcolog="#F9F1E7">
        <td><b>Nr. buc</b></td>
        <td><b>Carte</b></td>
        <td><b>Pret</b></td>
        <td><b>Total</b></td>
      </tr>
      <?php
        for($i=0; $i<count($_SESSION['id_carte']); $i++){
          print '<tr><td><input type="text" name="noulNrBuc['.$i.']" size="1" value="'.$_SESSION['nr_buc'][$i].'"></td>
          <td><b>'.$_SESSION['titlu'][$i].'</b> de '.$_SESSION['nume_autor'][$i].'</td>
          <td align="right">'.$_SESSION['pret'][$i].' lei</td>
          <td align="right">'.($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]).' lei</td></tr>';
          $totalGeneral = $totalGeneral + ($_SESSION['pret'][$i] * $_SESSION['nr_buc'][$i]);
        }
        print '<tr><td align="right" colspan="3"><b>Total in cos</b></td>
        <td aligh="right"><b>'.$totalGeneral.'</b> lei</td></tr>';
      ?>
    </table>
    <input type="submit" value="Modifica"><br><br>
    Introduceti <b>0</b> pentru cartile ce doriti sa le scoateti din cos!
    <h1>Continuare</h1>
    <table>
      <tr>
        <td width="200" align="center">
          <img src="../assets/img/left-arrow.gif">
          <a href="index.php">Continua cumparaturi</a>
        </td>
        <td width="200" align="center">
          <img src="../assets/img/cos-icon.gif">
          <a href="casa.php">Mergi la casa</a>
        </td>
      </tr>
    </table>
</div>

<?php include($footer) ?>