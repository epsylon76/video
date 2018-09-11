

<div id="loader" style="width:100%; height:100%; visibility:hidden; position: fixed; top: 50%; margin: 0 auto; text-align:center;">Veuillez patienter, compression des photos en cours &nbsp; &nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></div>

<div class="container">

  <h1>Vos Photos</h1>


  <div class="diapo" id="diapo" style="width:90%; margin:0 auto;">
    <?php echo $diaporama; ?>
  </div>
  <?php
  if(isset($_GET['id'])){
    ?>
    <div class="text-center" style="margin-top:50px; margin-bottom:50px;"><a class="btn btn-primary btn-lg" id="dl_photos" href="?dl_photos=<?php echo $_GET['id'];?>"><i class="fas fa-download"></i> Télécharger toutes les photos</a></div>
    <?php
  }
  ?>
</div>




<script>
$("#dl_photos").click(function(){
  $("#loader").css('visibility','visible');
  $("#dl_photos").css('visibility','hidden');
  $("#diapo").css('visibility','hidden');
});

$(document).ready(function(){
  $('.diapo').slick({
    lazyLoad: 'ondemand',
    autoplay: true,
    autoplaySpeed: 1500,
    fade: true,

  });
});


</script>
