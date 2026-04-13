<script src="/includes/js/chartjs/dist/chart.umd.js" type="text/javascript"></script>

<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="h5 mb-0 text-muted text-uppercase fw-bold">
            <i class="fas fa-chart-area me-2 text-primary"></i>Flux de données
        </h2>
        
        <div class="d-flex gap-2 align-items-center">
            <div class="btn-group btn-group-sm shadow-sm" role="group">
                <button type="button" class="btn btn-outline-secondary btn_heure" data-heure="6">6H</button>
                <button type="button" class="btn btn-outline-secondary btn_heure" data-heure="12">12H</button>
                <button type="button" class="btn btn-outline-secondary btn_heure" data-heure="24">24H</button>
            </div>

            <button type="button" id="convert" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-state="mbps">
                <i class="fas fa-exchange-alt me-1"></i> En Mbps
            </button>
        </div>
    </div>

    <div class="position-relative" style="height:40vh; width:100%">
        <div id="chart-loader" class="position-absolute top-0 start-0 w-100 h-100 d-none d-flex justify-content-center align-items-center bg-white bg-opacity-75" style="z-index: 10;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2 small fw-bold text-primary text-uppercase">Chargement...</div>
            </div>
        </div>
        
        <canvas id="chart"></canvas>
    </div>
</div>


<script>
 $(document).ready(function() {
    
    // --- 1. CONFIGURATION DATATABLES 2.1 ---
    const table = $('#liste').DataTable({
        ajax: {
            url: "/ajax/ajax_load_liste.php",
            type: "POST"
        },
        layout: {
            topStart: 'pageLength',
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'pagination'
        },
        order: [[0, 'desc']],
        autoWidth: false,
        pageLength: 25,
        columnDefs: [
            { targets: 2, className: 'text-truncate' },
            { targets: 5, className: 'text-end', orderable: false }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/fr-FR.json'
        },
        initComplete: function() {
            // Initialisation du redimensionnement des colonnes après le chargement
            $("#liste").colResizable({
                liveDrag: true,
                gripInnerHtml: "<div class='grip'></div>",
                draggingClass: "dragging",
                resizeMode: 'fit',
                postbackSafe: true
            });
        },
        drawCallback: function() {
            // Réactivation des tooltips Bootstrap 5 à chaque mouvement du tableau
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(t => new bootstrap.Tooltip(t));
        }
    });

    // --- 2. CONFIGURATION CHART.JS & LOADER ---
    let maChart;
    const $loader = $('#chart-loader');
    const chartColors = {
        dl_video: '#4834d4',    // Indigo
        play_video: '#686de0',  // Bleu moyen
        diapo: '#be2edd',       // Violet
        dl_photo: '#e056fd'     // Rose/Violet clair
    };

    // Fonction d'initialisation du graphique
    function initChart(data) {
        const ctx = document.getElementById('chart').getContext('2d');
        maChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(row => row.periode),
                datasets: [
                    { label: 'Dl vidéo', data: data.map(row => row.dl_video), backgroundColor: chartColors.dl_video, borderRadius: 4 },
                    { label: 'Lecture vidéo', data: data.map(row => row.play_videos), backgroundColor: chartColors.play_video, borderRadius: 4 },
                    { label: 'Diapo photo', data: data.map(row => row.defile_photo), backgroundColor: chartColors.diapo, borderRadius: 4 },
                    { label: 'Dl photos', data: data.map(row => row.dl_photos), backgroundColor: chartColors.dl_photo, borderRadius: 4 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                },
                scales: {
                    x: { stacked: true, grid: { display: false } },
                    y: { stacked: true, beginAtZero: true, grid: { borderDash: [5, 5] } }
                }
            }
        });
    }

    // Fonction universelle de chargement/mise à jour du graphique
    function loadChartData(customParams = {}) {
        const state = $('#convert').data('state');
        const heure = $('.btn_heure.active').data('heure') || 24;
        
        const requestData = $.extend({ 'state': state, 'heure': heure }, customParams);
        
        $.ajax({
            url: '/ajax/ajax_chart.php',
            type: 'POST',
            data: requestData,
            dataType: 'json',
            beforeSend: function() {
                $loader.removeClass('d-none'); // Affiche le loader
            },
            success: function(response) {
                if (!maChart) {
                    initChart(response);
                } else {
                    maChart.data.labels = response.map(row => row.periode);
                    maChart.data.datasets[0].data = response.map(row => row.dl_video);
                    maChart.data.datasets[1].data = response.map(row => row.play_videos);
                    maChart.data.datasets[2].data = response.map(row => row.defile_photo);
                    maChart.data.datasets[3].data = response.map(row => row.dl_photos);
                    maChart.update('active');
                }
            },
            complete: function() {
                // Petit délai pour éviter le clignotement si le serveur est trop rapide
                setTimeout(() => { $loader.addClass('d-none'); }, 300);
            }
        });
    }

    // --- 3. GESTION DES ÉVÉNEMENTS ---

    // Toggle Unité (Mbps / Go)
    $('#convert').on('click', function() {
        const btn = $(this);
        const newState = (btn.data('state') === 'mbps') ? 'go' : 'mbps';
        
        btn.data('state', newState);
        btn.html(newState === 'go' ? '<i class="fas fa-database me-1"></i> En Go' : '<i class="fas fa-exchange-alt me-1"></i> En Mbps');
        
        loadChartData();
    });

    // Changement de période (6H, 12H, 24H)
    $('.btn_heure').on('click', function() {
        $('.btn_heure').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-primary').removeClass('btn-outline-secondary');
        
        loadChartData({ 'heure': $(this).data('heure') });
    });

    // Redimensionnement de la fenêtre
    $(window).on('resize', function() {
        table.columns.adjust();
    });

    // --- 4. LANCEMENT INITIAL ---
    loadChartData(); // Charge le graphique au démarrage

});
</script>