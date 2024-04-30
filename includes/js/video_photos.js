$("#bouton-dl").click(function() {
  var email = $(this).data('email');
  var chemin = $(this).data('chemin');
  var taille = $(this).data('taille');
  $.ajax({
    url: '/ajax/clic_dl.php',
    type: 'POST',
    data: {'chemin' : chemin, 'email' : email, 'taille' : taille ,'action' : 'dl_video'}
  });
});


$('#id-video').on('play', function() {
var chemin = $(this).data('chemin');
console.log(chemin);
  $.ajax({
    url: '/ajax/play_video.php',
    type: 'POST',
    data: {'chemin' : chemin ,'action' : 'play_videos'},
    success: function(data, textStatus, jqXHR){
        console.log('test2');
    }
  });
});