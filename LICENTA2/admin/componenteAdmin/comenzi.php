<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrareComenzi = $path . '/actiuni/admin/prelucrare_comenzi.php';

  include($autorizare);
  include($headerAdmin);

  print '
    <div class="admin-main-content admin-comenzi-content">
      <h1>Comenzi</h1>
      <h4 class="italic">Comenzi onorate</h4>
  ';
  $sqlNrTranzactii = "SELECT * FROM tranzactii WHERE comanda_onorata=0";
  $resursaNrTranzactii = mysqli_query($con, $sqlNrTranzactii);
  $nrTranzactii = mysqli_num_rows($resursaNrTranzactii);

  if($nrTranzactii === 0){
    print "<em>Momentan nu exista comenzi neonorate!</em>";
  }

  $sqlTranzactii = "SELECT id_tranzactie, date_format(data_tranzactie,'%d-%n-%Y') as data_tranzactie, nume_cumparator, adresa_cumparator from tranzactii where comanda_onorata=0";
  $resursaTranzactii = mysqli_query($con, $sqlTranzactii);
  while($rowTranzactie = mysqli_fetch_array($resursaTranzactii)){
    $totalGeneral = 0;
  ?>
  <form class="comenzi-form" action="<?=$prelucrareComenzi?>" method="POST">
    <p class="no-margin"><em>Data comenzii:</em> <b><?=$rowTranzactie['data_tranzactie']?></b></p>
    <p class="no-margin"><em>Client:</em> <b><?=$rowTranzactie['nume_cumparator']?></b></p> 
    <p class="no-margin"><em>Adresa client:</em> <b><?=$rowTranzactie['adresa_cumparator']?></b></p>
    <div class="comenzi-table">
      <div class="comenzi-table-row">
        <p class="width70 no-margin bold">Titlu / Autor</p>
        <p class="width10 no-margin bold center-text">Nr. buc</p>
        <p class="width10 no-margin bold center-text">Pret</p>
        <p class="width10 no-margin bold center-text">Total</p>
      </div>
      <?php 
        $sqlCarti = "SELECT titlu, nume_autor, pret, nr_buc FROM vanzari, carti, autori WHERE carti.id_carte=vanzari.id_carte AND carti.id_autor=autori.id_autor AND id_tranzactie=".$rowTranzactie['id_tranzactie'];
        $resursaCarti = mysqli_query($con, $sqlCarti);
        while($rowCarte = mysqli_fetch_array($resursaCarti)){
          print '
            <div class="comenzi-table-row">
              <p class="width70 no-margin">'.$rowCarte['titlu'].' de '.$rowCarte['nume_autor'].' </p>
              <p class="width10 no-margin center-text">'.$rowCarte['nr_buc'].'</p>
              <p class="width10 no-margin center-text">'.$rowCarte['pret'].'</p>
          ';
          $total = $rowCarte['pret'] * $rowCarte['nr_buc'];
          print '<p class="width10 no-margin center-text">'.$total.'</p>
            </div>';
          $totalGeneral = $totalGeneral + $total;
        }
      ?>
      <div class="comenzi-table-row">
        <input type="hidden" name="id_tranzactie" value="<?=$rowTranzactie['id_tranzactie']?>" />
        <input type="submit" class="btn btn-primary comenzi-btn" name="comanda_onorata" value="Comanda onorata" />
        <input type="submit" class="btn btn-primary comenzi-btn" name="anuleaza_comanda" value="Anuleaza comanda" />  
        <p class="comenzi-totalComanda no-margin width100 bold">Total comanda: <?=$totalGeneral?> lei</p>
      </div>
    </div>   
  </form>
<?php } include($footerAdmin); ?>