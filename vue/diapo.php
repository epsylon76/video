<div class="container">

  <h1>Diaporama</h1>
  <p><strong>Date</strong> : <?php echo date('d/m/Y', $date); ?></p>
  <p><strong>Nombre de photos</strong> : <?php echo $nb; ?> </p>
  <p><strong>Taille</strong> : <?php echo number_format($taille / 1048576, 2); ?> Mo</p>

  <div class="owl-carousel owl-theme" style="width:90%; margin:0 auto;">
    <?php echo $diaporama; ?>
  </div>


</div> <!--container -->

<script src="includes/js/owl.carousel.min.js"></script>

<script>
$('.owl-carousel').owlCarousel({
    items:4,
    lazyLoad:true,
    loop:true,
    margin:10
});
</script>
