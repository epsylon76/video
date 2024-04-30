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