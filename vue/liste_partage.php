
<div class="container">
  <h2>Partages</h2>
  <table id="liste" class="table table-striped" style="width:100%">
    <thead>
      <tr>
        <th>ID</th>
        <th>date partage</th>
        <th>chemin</th>
        <th>email</th>
        <th>admin</th>
        <th>actions</th>
      </tr>
    </thead>
  </table>
</div>

<script>
  $(document).ready(function() {
    $('#liste').DataTable({
      "ajax": {
        "url": "/ajax/ajax_load_liste.php",
        "type": "POST"
      },
      "ordering": true,
      "order": [
        [0, 'desc']
      ],

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