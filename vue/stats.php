
<div class="container">
  <h1>Statistiques</h1>
  <div class="row">

    <div class="col">
      Taille du dossier ZIP : <?php echo $taille.' Mo'; ?>
    </div>

    <div class="col">
      <div class="progress">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"  style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $taille; ?>" aria-valuemin="0" aria-valuemax="100000"><?php echo floor($percent).' %'; ?></div>
      </div>
    </div>

    <div class="col">
      <a href="#">Vider</a>
    </div>
  </div>

  <?php  foreach($vol as $item_vol){ ?>
    <div class="row">

      <div class="col">
        <?php echo $item_vol['nom'].' -> Libre : '.$item_vol['free_human'].' , Total : '.$item_vol['total_human'];?>
      </div>

      <div class="col">
        <div class="progress">
          <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"  style="width:<?php echo $item_vol['percent']; ?>%" aria-valuenow="<?php echo $item_vol['occupe']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $item_vol['total']; ?>">
            <?php echo floor($item_vol['percent']).' %'; ?>
          </div>
        </div>
      </div>

      <div class="col">
      </div>

    </div>

  <?php } ?>

</div> <!-- container -->
