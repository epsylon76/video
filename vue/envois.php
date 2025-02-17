<div class="container">

  <h2>Paramétrage des envois</h2>
  <h6>Heure système : <?php echo date('d/m/Y H:i');?></h6>
  <h5>Début des envois</h5>
  <form action="/actions/set_envois" method="post">
    <input type="datetime-local" style="<?php echo $style; ?>" value="<?php echo $params['depart_file']; ?>" name="depart_file"></input>&nbsp;<input type="submit" value="modifier" required></input>
  </form>
  <br />
  <small style="background-color:orange; padding:10px; border-radius:5px;margin:5px;;">Programmé</small>
  <small style="background-color:lightgreen; padding:10px; border-radius:5px;margin:5px;;">En cours</small>
  <small style="background-color:lightblue; padding:10px; border-radius:5px;margin:5px;;">Terminé</small>
  <br />



  <h2>File d'attente des envois</h2>
  <table id="liste" class="table table-striped" style="width:100%; background-color:rgba(255,255,255, 0.7); ">
    <thead>
      <tr>
        <th>Email</th>
        <th>Date d'ajout</th>
        <th>Type</th>
        <th>Envoyé</th>
        <th>Admin</th>
      </tr>
    </thead>
  </table>

  

  <div class="bordered-black" style="display:inline-block">
  <h4>Renvoi par date</h4>
    <form action="/actions/renvoi_bulk" method="post">
      <input type="date" value="" required name="date"/>
      <br />
      <input type="radio" id="chk_immediat" name="immediat" value="1">
      <label for="chk_immediat">Immediat</label>
      <input type="radio" id="chk_programme" name="immediat" value="0" checked>
      <label for="chk_programme">Programmé</label>
      <br />
      <input type="submit" value="Renvoi" />
    </form>
  </div>

</div>

<script>
  $(document).ready(function() {
    $('#liste').DataTable({
      "ajax": {
        "url": "/ajax/ajax_load_file.php",
        "type": "POST"
      },
      "columnDefs" : [{"targets":1, "type":"date-euro"}],
      "ordering": true,
      "order": [1, 'desc'],

      language: {
        processing: "Traitement en cours...",
        search: "Rechercher&nbsp;:",
        lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
        info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix: "",
        loadingRecords: "Chargement en cours...",
        zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable: "Aucune donnée disponible dans le tableau",
        paginate: {
          first: "Premier",
          previous: "Pr&eacute;c&eacute;dent",
          next: "Suivant",
          last: "Dernier"
        },
        aria: {
          sortAscending: ": activer pour trier la colonne par ordre croissant",
          sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
      }
    });
  });
</script>