$("#bouton-dl").click(function() {
  console.log('clic dl');
  var email = $(this).data('email');
  var chemin = $(this).data('chemin');
  var taille = $(this).data('taille');
  var action = $(this).data('action');
  $.ajax({
    url: '/ajax/clic_dl.php',
    type: 'POST',
    data: {'chemin' : chemin, 'email' : email, 'taille' : taille ,'action' : action}
  });
});



$('#id-video').one('play', function() {
  
    var chemin = $(this).data('chemin');
    $.ajax({
      url: '/ajax/play_video.php',
      type: 'POST',
      data: {'chemin': chemin, 'action': 'play_videos'},
    });
    
});


// delais pour pas que la meme image soit comptabilisé 2 fois si on clique rapidement
var delaisNext = true;
$('button.slick-next').on('click', function() {
  if(!delaisNext) { return; }

  var chemin = $(this).closest('.slider-photo').data('chemin');
  var data = $(this).closest('.slider-photo').data('data');
  var imgSrc = $(".slick-active img").attr("src");

  delaisNext = false;
   setTimeout(function() {
    delaisNext = true;
  }, 405);

  $.ajax({
    url: '/ajax/defile_photo.php',
    type: 'POST',
    data: {'chemin': chemin, 'data': data, 'action': 'defile_photo', 'imgSrc': imgSrc },
    success: function(data, textStatus, jqXHR){
      console.log(data);
    }
  });
});

var delaisPrev = true;
$('button.slick-prev').on('click', function() {
  if(!delaisPrev) { return; }

  delaisPrev = false;
  setTimeout(function() {
    delaisPrev = true;
  }, 405);

  var chemin = $(this).closest('.slider-photo').data('chemin');
  var data = $(this).closest('.slider-photo').data('data');
  var imgSrc = $(".slick-active img").attr("src");
  
  $.ajax({
    url: '/ajax/defile_photo.php',
    type: 'POST',
    data: {'chemin': chemin, 'data': data, 'action': 'defile_photo', 'imgSrc': imgSrc },
    success: function(data, textStatus, jqXHR){
      console.log(data);
    }
  });
});