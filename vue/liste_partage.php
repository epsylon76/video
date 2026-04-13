
<div class="container-fluid px-md-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-share-nodes me-2 text-primary"></i>Gestion des Partages
            </h2>
            <p class="text-muted mb-0">Liste active des accès envoyés aux clients</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-3"> <div class="table-responsive">
                <table id="liste" class="table table-hover table-striped align-middle w-100" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="border-bottom-0 text-secondary fw-semibold">ID</th>
                            <th class="border-bottom-0 text-secondary fw-semibold">Date partage</th>
                            <th class="border-bottom-0 text-secondary fw-semibold">Chemin</th>
                            <th class="border-bottom-0 text-secondary fw-semibold">Email</th>
                            <th class="border-bottom-0 text-secondary fw-semibold">Admin</th>
                            <th class="border-bottom-0 text-secondary fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>

        </div>
    </div>
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
      "responsive": true, // Très utile pour les petits écrans
      "pageLength": 25,

      // On personnalise le rendu des colonnes si besoin via columnDefs
      "columnDefs": [{
          "targets": -1,
          "className": "text-end"
        } // Aligne la colonne 'actions' à droite
      ],

      "language": {
        "emptyTable": "Aucune donnée disponible dans le tableau",
        "loadingRecords": '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Chargement...</span></div>',
        "processing": "Traitement en cours...",
        "search": "Rechercher :",
        "lengthMenu": "Afficher _MENU_ entrées",
        "info": "Affichage de _START_ à _END_ sur _TOTAL_ partages",
        "infoEmpty": "Affichage de 0 à 0 sur 0 partages",
        "infoFiltered": "(filtré de _MAX_ au total)",
        "paginate": {
          "first": "Premier",
          "previous": "Précédent",
          "next": "Suivant",
          "last": "Dernier"
        }
      },
      // Callback pour styliser les lignes après le chargement
      "drawCallback": function(settings) {
        // Optionnel : on peut ajouter des classes BS5 aux éléments générés par DataTables ici
        $('.dataTables_paginate .paginate_button').addClass('btn btn-sm');
      }
    });
  });
</script>