<?php 
    $path = "/licenta2";
    $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
    $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
    $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
    $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
    $formulareModificareStergere = $path . '/admin/componenteAdmin/formulare_modificare_stergere.php';

    require '../../vendor/autoload.php';
    $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

    include($autorizare);
    include($headerAdmin);
?>
<div class="admin-main-content admin-modif-sterge-content">
  <h1>Modificare sau stergere</h1>
  <p class="modif-sterge-nota italic"><b>Nota:</b> Nu veti putea sterge domenii care au carti in ele. Inainte de a sterge domeniul, modificati cartile din el astefel incat sa apartina altor domenii. De asemenea nu veti putea sterge un autor daca exista carti in baza de date care au acel autor.</p>
  
  <div class="modif-sterg-items">
    <div class="modif-sterg-item">
      <h5 class="modif-sterg-titlu bold italic">Selecteaza domeniul ce doresti sa il modifici sau stergi:</h5>
      <form class="modif-sterg-form" action="<?=$formulareModificareStergere?>" method="POST">
        <h6 class="width10">Domeniu:</h6> 
        <select class="width90" name="id_domeniu">
          <?php 
            $sql = 'PREFIX c: <http://chinde.ro#>
                select ?idDomeniu ?numeDomeniu where {
                  GRAPH c:Domenii {
                    ?idDomeniu c:numeDomeniu ?numeDomeniu
                  }
                } order by ?numeDomeniu';
              $resursa = $client->query($sql);
            foreach($resursa as $row){
              $idDomeniu = parse_url($row->idDomeniu)["fragment"];
              print "<option value='".$idDomeniu."'>".$row->numeDomeniu."</option>";
            }
          ?>
        </select>
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="modifica_domeniu" value="Modifica" />
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="sterge_domeniu" value="Sterge" />
      </form>
    </div>  

    <div class="modif-sterg-item">
      <h5 class="modif-sterg-titlu bold italic">Selecteaza autorul ce doresti sa il modifici sau stergi:</h5>
      <form class="modif-sterg-form" action="<?=$formulareModificareStergere?>" method="POST">
        <h6 class="width10">Autor:</h6>
        <select class="width90" name="id_autor">
          <?php 
            $sql = 'PREFIX c: <http://chinde.ro#>
            select ?idAutor ?numeAutor ?descriere ?sursaDescriere where {
              GRAPH c:Autori {
                ?idAutor c:numeAutor ?numeAutor.
                OPTIONAL {
                  ?idAutor c:descriere ?descriere.
                  ?idAutor c:sursaDescriere ?sursaDescriere.
                }
              }
            } order by ?numeAutor';
            $resursa = $client->query($sql);
            foreach($resursa as $row){
              $idAutor = parse_url($row->idAutor)["fragment"];
                print "<option value='".$idAutor."'>".$row->numeAutor."</option>";
              }
            ?>
        </select>
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="modifica_autor" value="Modifica" />
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="sterge_autor" value="Sterge" />
      </form>
    </div>

    <div class="modif-sterg-item">
      <h5 class="modif-sterg-titlu bold italic">Selecteaza autorul si scrie titlul cartii ce doresti sa o modifici sau stergi:</h5>
      <form class="modif-sterg-form" action="<?=$formulareModificareStergere?>" method="POST">
          <div class="modif-sterg-form-field">
            <h6 class="width10">Autor:</h6>
            <select class="width90" name="id_autor">
              <?php
                $sql = 'PREFIX c: <http://chinde.ro#>
                  select ?idAutor ?numeAutor ?descriere ?sursaDescriere where {
                    GRAPH c:Autori {
                      ?idAutor c:numeAutor ?numeAutor.
                      OPTIONAL {
                        ?idAutor c:descriere ?descriere.
                        ?idAutor c:sursaDescriere ?sursaDescriere.
                      }
                    }
                  } order by ?numeAutor';
                $resursa = $client->query($sql);
                foreach($resursa as $row){
                  $idAutor = parse_url($row->idAutor)["fragment"];
                  print "<option value='".$idAutor."'>".$row->numeAutor."</option>";
                }
              ?>
            </select>
          </div>
          <div class="modif-sterg-form-field">
            <h6 class="width10">Titlu:</h6>
            <input class="width90" type='text' name="titlu" />
          </div>
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="modifica_carte" value="Modifica" />
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="sterge_carte" value="Sterge" />
      </form>
    </div>
  </div>
 
</div>
<?php include($footerAdmin); ?>