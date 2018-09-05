

<div id="loader" style="width:100%; height:100%; visibility:hidden; position: fixed; top: 50%; margin: 0 auto; text-align:center;">Veuillez patienter, compression des photos en cours &nbsp; &nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></div>

<div class="container">

  <div class="text-center" style="margin-top:50px; margin-bottom:50px;"><a class="btn btn-primary btn-lg" id="dl_photos" href="?dl_photos=<?php echo $_GET['photos'];?>"><i class="fas fa-download"></i> Télécharger toutes les photos</a></div>


  <div class="owl-carousel" id="diapo">

    <?php echo $diaporama; ?>


  </div>

</div>




<script>
$("#dl_photos").click(function(){
  $("#loader").css('visibility','visible');
  $("#dl_photos").css('visibility','hidden');
  $("#diapo").css('visibility','hidden');
});

$('.owl-carousel').owlCarousel({
  lazyLoad:true,
  lazyLoadEager:true,
  loop:true,
  margin:10,
  items:2,
  center:true,
  loop:true,
  startPosition :3,
  nav : true
});
</script>
