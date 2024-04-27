$("#bouton-dl").click(function() {
    console.log('test');
    var email = $(this).data('email');
    var chemin = $(this).data('chemin');
    $.ajax({
      url: '/ajax/clic_dl.php',
      type: 'POST',
      data: {'chemin' : chemin, 'email' : email, 'action' : 'dl_video'}
    });
  });