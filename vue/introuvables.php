<div class="container">
<?php
if($introuvable){
  echo '<h5>Partages introuvables</h5>';
  foreach($introuvable as $ligne){
    ?>

    <div class="row">
      <div class="col">
        <?php echo $ligne['id']; ?>
        &nbsp;
        <?php echo $ligne['chemin']; ?>
        &nbsp;
        <a href="?page=unset_partage&id=<?php echo $ligne['id']; ?>&retour=introuvables"><i class="fas fa-trash-alt" style="color:red;"></i></a>
      </div>
    </div>

    <?php
  }
}
if($introuvable){
echo '<a href="?page=clear_introuvables" class="btn btn-warning">Effacer tout les partages introuvables</a>';
}else{
  echo '<br><br><h4>Il n\'y a pas de partages introuvables actuellement';
}
?>
</div>
