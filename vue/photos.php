

<br><a class="btn btn-success" href="?cle=<?php echo $_GET['cle'] ?>"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>

</div>

<div class="container">

  <h1>Vos Photos</h1>


  <div class="diapo" id="diapo" style="width:90%; margin:0 auto;">
    <?php echo $diaporama; ?>
  </div>
  <?php
  if(isset($_GET['id'])){
    ?>
    <div class="text-center" style="margin-top:50px; margin-bottom:50px;">
      <a class="btn btn-primary btn-lg" id="dl_photos" href="?cle=<?php echo $_GET['cle'] ?>&dl_photos=<?php echo $_GET['id'];?>">
        <i class="fas fa-download"></i> Télécharger toutes les photos
      </a>
    </div>
    <?php
  }
  ?>
</div>




<script>

$(document).ready(function(){
  $('.diapo').slick({
    lazyLoad: 'ondemand',
    autoplay: true,
    autoplaySpeed: 1500,
    fade: true,

  });
});


</script>
