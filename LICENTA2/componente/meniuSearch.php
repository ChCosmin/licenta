<?php 
 $path = "/licenta2";
 $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

 $cautare = $path . '/componente/cautare.php';
?>

<form action="<?php echo $cautare ?>" method="GET" class="form-inline my-2 my-lg-0">
  <input name="cuvant" class="form-control mr-sm-2" type="Cautare" placeholder="Tasteaza cuvant" aria-label="Cautare">
  <button class="btn btn-primary my-2 my-sm-0 meniu-search-btn" type="submit">Cauta</button>
</form>

