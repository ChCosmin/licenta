<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrare = $path . '/actiuni/admin/prelucrare_adaugare.php';

  require '../../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  include($autorizare);
  include($headerAdmin);
?>
<div class="admin-main-content admin-adaugare-content">
  <h1>Adaugare</h1>
  <div class="adaugare-item">
    <h5 class="adaugare-item-titlu bold italic">Adauga domeniu</h5>
    <form class="adaugare-item-form" action="<?=$prelucrare?>" method="POST">
      <input class="width100" type="text" name="domeniu_nou" placeholder="Domeniu nou"/>
      <input class="btn btn-primary adauga-form-btn width100" type="submit" name="adauga_domeniu" value="Adauga" />
    </form>
  </div>
  
  <div class="adaugare-item">
    <h5 class="adaugare-item-titlu bold italic">Adauga autor</h5>
    <form class="adaugare-item-form" action="<?=$prelucrare?>" method="POST">
      <input class="width100" type="text" name="autor_nou" placeholder="Autor nou"/>
      <input class="width100" type="text" name="autor_descriere_nou" placeholder="Descriere autor nou"/>
      <input class="width100" type="text" name="sursa_descriere" placeholder="Sursa descriere"/>
      <input class="btn btn-primary adauga-form-btn width100" type="submit" name="adauga_autor" value="Adauga" />
    </form>
  </div>
 
  <div class="adaugare-item">
    <h5 class="adaugare-item-titlu bold italic">Adauga carte</h5>
    <form class="adaugare-item-form" action="<?=$prelucrare?>" method="POST">
  
        <div class="adaugare-form-field">
          <h6 class="width20">Domeniu:</h6>
          <select class="width100" name="id_domeniu">
            <?php 
              $sql = 'PREFIX c: <http://chinde.ro#>
              select ?idDomeniu ?numeDomeniu where {
                  GRAPH c:Domenii {
                    ?idDomeniu c:numeDomeniu ?numeDomeniu   
                  }
              } order by ?numeDomeniu';
              $resursa=$client->query($sql);
              
              foreach($resursa as $row){
                $idDomeniu = parse_url($row->idDomeniu)["fragment"];
                print '<option value="'.$idDomeniu.'">'.$row->numeDomeniu.'</option>';
              };
            ?>
          </select>          
        </div>

        <div class="adaugare-form-field">
          <h6 class="width20">Autor:</h6>
          <select class="width100" name="id_autor">
            <?php 
              $sql = 'PREFIX c: <http://chinde.ro#>
                select ?idAutor ?numeAutor where {
                  GRAPH c:Autori {
                    ?idAutor c:numeAutor ?numeAutor
                  }
                } order by ?numeAutor';
              $resursa=$client->query($sql);
              
              foreach($resursa as $row){
                $idAutor = parse_url($row->idAutor)["fragment"];
                print '<option value="'.$idAutor.'">'.$row->numeAutor.'</option>';
              }
            ?>
          </select>
        </div>

        <div class="adaugare-form-field">
          <h6 class="width20">Titlu:</h6>
          <input class="width100" type="text" name="titlu" />
        </div>

        <div class="adaugare-form-field">
          <h6 class="width20">Descriere:</h6>
          <textarea class="width100 adaugare-form-textarea" name="descriere" rows="8"></textarea>
        </div>
        
        <div class="adaugare-form-field">
          <h6 class="width20">Pret:</h6>
          <input class="width100" type="text" name="pret" />
        </div>

        <div class="adaugare-form-field">
          <input class="btn btn-primary adauga-form-btn width100" type="submit" name="adauga_carte" value="Adauga" />
        </div>
    </form>
  </div>
 
</div>
<?php include($footerAdmin); ?>